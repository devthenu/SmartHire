<div class="mb-3">
    <label for="title">Job Title</label>
    <input type="text" name="title" value="{{ old('title', $job->title ?? '') }}" class="form-control" required>
</div>

<div class="mb-3">
    <label for="description">Description</label>
    <textarea name="description" class="form-control" required>{{ old('description', $job->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="location">Location</label>
    <input type="text" name="location" value="{{ old('location', $job->location ?? '') }}" class="form-control" required>
</div>

<div class="mb-3">
    <label for="type">Type</label>
    <select name="type" class="form-control" required>
        @foreach(['full-time','part-time','contract'] as $type)
            <option value="{{ $type }}" {{ old('type', $job->type ?? '') === $type ? 'selected' : '' }}>
                {{ ucfirst($type) }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="salary">Salary (Optional)</label>
    <input type="number" name="salary" value="{{ old('salary', $job->salary ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label for="deadline">Application Deadline</label>
    <input type="date" name="deadline"
        value="{{ old('deadline', isset($job->deadline) ? \Carbon\Carbon::parse($job->deadline)->format('Y-m-d') : '') }}"
        class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Required Skills</label>
    <select name="skills[]" class="form-control" multiple>
        @foreach($skills as $skill)
            <option value="{{ $skill->id }}"
                @selected(collect(old('skills', isset($job) ? $job->skills->pluck('id')->all() : []))->contains($skill->id))>
                {{ $skill->name }}
            </option>
        @endforeach
    </select>
    <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple.</small>
</div>