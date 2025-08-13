<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Models\ResumeTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;

class ResumeController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $resumes = $user->resumes()->with('resumeTemplate')->get();

        return view('jobseeker.dashboard', compact('resumes'));
    }

    public function create()
    {
        $templates = ResumeTemplate::orderBy('name')->get();

        return view('jobseeker.resume.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'education' => 'required|string',
            'experience' => 'required|string',
            'skills' => 'required|string',
            'resume_template_id' => 'required|exists:resume_templates,id',
        ]);

        // Assign owner + default title if missing
        $validated['user_id'] = Auth::id();
        if (empty($validated['title'])) {
            $validated['title'] = 'My Resume ' . now()->format('Ymd_His');
        }

        $resume = Resume::create($validated);

        return redirect()->route('jobseeker.resume.download', $resume->id);
    }

    public function download(Resume $resume)
    {
        $user = Auth::user();
        if ($resume->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        $resume->load('resumeTemplate');

        // QR as SVG (no Imagick/GD needed)
        $writer = new Writer(
            new ImageRenderer(
                new RendererStyle(200),
                new SvgImageBackEnd()
            )
        );
        $qrSvg = $writer->writeString(route('jobseeker.resume.show', $resume->id));
        $qrCode = base64_encode($qrSvg);

        // Choose template view by name (fallback to simple)
        $view = match ($resume->resumeTemplate->name ?? '') {
            'Simple Modern' => 'resumes.templates.simple',
            'Elegant Minimal' => 'resumes.templates.elegant',
            'Creative Professional' => 'resumes.templates.creative',
            default => 'resumes.templates.simple',
        };

        $pdf = Pdf::loadView($view, [
            'resume' => $resume,
            'qrCode' => $qrCode,
        ]);

        // Ensure storage dir exists before save
        $dir = storage_path('app/public/resume');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Save + persist path
        $filename = 'resume_' . $resume->id . '.pdf';
        $pdf->save($dir . '/' . $filename);

        $resume->cv_pdf_path = 'resume/' . $filename; // matches your folder name
        $resume->save();

        // Stream a download to the browser as well
        return $pdf->download('resume.pdf');
    }

    public function show(Resume $resume)
    {
        $user = Auth::user();
        if ($resume->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        $resume->load('resumeTemplate');

        return view('jobseeker.resume.show', compact('resume'));
    }

    public function edit(Resume $resume)
    {
        if ($resume->user_id !== Auth::id()) {
            abort(403);
        }

        $templates = ResumeTemplate::orderBy('name')->get();

        return view('jobseeker.resume.edit', compact('resume', 'templates'));
    }

    public function update(Request $request, Resume $resume)
    {
        if ($resume->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'resume_template_id' => 'required|exists:resume_templates,id',
            'title' => 'nullable|string|max:255',
            'education' => 'nullable|string',
            'experience' => 'nullable|string',
            'skills' => 'nullable|string',
        ]);

        $resume->update($validated);

        return redirect()->route('jobseeker.dashboard')->with('success', 'Resume updated!');
    }

    public function destroy(Resume $resume)
    {
        if ($resume->user_id !== Auth::id()) {
            abort(403);
        }

        $resume->delete();

        return redirect()->route('jobseeker.dashboard')->with('success', 'Resume deleted.');
    }

    public function list()
    {
        $user = Auth::user();

        $resumes = Resume::with('resumeTemplate')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('jobseeker.resumes.index', compact('resumes'));
    }
}
