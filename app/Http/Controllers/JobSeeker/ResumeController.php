<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Models\ResumeTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SimpleSoftwareIO\QrCode\Generator;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;

class ResumeController extends Controller


{

    // ResumeController or DashboardController
    public function dashboard()
    {
        $user = auth()->user();
        $resumes = $user->resumes()->with('resumeTemplate')->get();

        

        return view('jobseeker.dashboard', compact('resumes'));
    }

    public function create()
    {
        $templates = ResumeTemplate::all();
        

        return view('jobseeker.resume.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'education' => 'required|string',
            'experience' => 'required|string',
            'skills' => 'required|string',
            'resume_template_id' => 'required|exists:resume_templates,id',
        ]);

        // Add a default title if none is provided
        $validated['user_id'] = Auth::id();
        if (empty($validated['title'])) {
            $validated['title'] = 'My Resume ' . now()->format('Ymd_His');
        }

        $validated['user_id'] = Auth::id();
        $resume = Resume::create($validated);

        

        return redirect()->route('jobseeker.resume.download', $resume->id); // ✅ Redirect to the download method with the new resume ID
    }

    public function download(Resume $resume)
    {
        $user = auth()->user();
        if ($resume->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        $resume->load('resumeTemplate');

        $writer = new Writer(
            new ImageRenderer(
                new RendererStyle(200),
                new SvgImageBackEnd()
            )
        );
        $qrSvg = $writer->writeString(route('jobseeker.resume.show', $resume->id));
        $qrCode = base64_encode($qrSvg);

        $view = match($resume->resumeTemplate->name) {
            'Simple Modern' => 'resumes.templates.simple',
            'Elegant Minimal' => 'resumes.templates.elegant',
            'Creative Professional' => 'resumes.templates.creative',
            default => 'resumes.templates.simple',
        };

        $pdf = Pdf::loadView($view, [
            'resume' => $resume,
            'qrCode' => $qrCode,
        ]);

        // --- START: ADDED CODE FROM STEP 6 ---

        // 1. Generate a unique filename and save the PDF to storage
        $filename = 'resume_' . $resume->id . '.pdf';
        $pdf->save(storage_path('app/public/resumes/' . $filename));

        // 2. Store the path in the database
        // NOTE: This assumes you have a 'cv_pdf_path' column on your 'resumes' table.
        $resume->cv_pdf_path = 'resumes/' . $filename;
        $resume->save();

        // --- END: ADDED CODE FROM STEP 6 ---

        return $pdf->download('resume.pdf');
    }

    public function show(Resume $resume)
    {
        $user = auth()->user();
        if ($resume->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        $resume->load('resumeTemplate');

        return view('jobseeker.resume.show', compact('resume'));
    }

    public function edit(Resume $resume)
    {
        if ($resume->user_id !== auth()->id()) {
            abort(403);
        }

        $templates = ResumeTemplate::all();

        return view('jobseeker.resume.edit', compact('resume', 'templates'));
    }

    public function update(Request $request, Resume $resume)
    {
        if ($resume->user_id !== auth()->id()) {
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
        if ($resume->user_id !== auth()->id()) {
            abort(403);
        }

        $resume->delete();

        return redirect()->route('jobseeker.dashboard')->with('success', 'Resume deleted.');
    }
    
    public function list()
    {
        $user = auth()->user();

        $resumes = Resume::with('resumeTemplate')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('jobseeker.resumes.index', compact('resumes'));
    }





}