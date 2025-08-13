@extends('layouts.app')

@section('content')
<div class="container py-6">
    <div class="max-w-3xl mx-auto">
        <h2 class="text-xl font-semibold mb-4">Your Skills</h2>
        
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                @foreach($errors->all() as $e)
                    <div>• {{ $e }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('jobseeker.skills.update') }}">
            @csrf
            
            <div id="skills-wrapper">
                {{-- Guard against missing variables and ensure at least one row --}}
                @php
                    $rows = (isset($userSkillsWithProficiency) && $userSkillsWithProficiency->count() > 0)
                        ? $userSkillsWithProficiency
                        : collect([['skill_id' => '', 'proficiency_level' => 'beginner']]); // at least one row
                @endphp

                @foreach($rows as $index => $userSkill)
                    <div class="skill-row flex gap-3 mb-3">
                        <select name="skills[]" class="border rounded p-2 w-1/2 form-control" required>
                            <option value="">Select a skill</option>
                            @if(isset($allSkills))
                                @foreach($allSkills as $skill)
                                    <option value="{{ $skill->id }}" 
                                        @selected($skill->id == ($userSkill['skill_id'] ?? ''))>
                                        {{ $skill->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        
                        <select name="levels[]" class="border rounded p-2 w-1/3 form-control">
                            @foreach(['beginner','intermediate','advanced','expert'] as $opt)
                                <option value="{{ $opt }}"
                                    @selected(($userSkill['proficiency_level'] ?? 'beginner') === $opt)>
                                    {{ ucfirst($opt) }}
                                </option>
                            @endforeach
                        </select>
                        
                        <button type="button" class="px-2 py-1 bg-red-500 text-white rounded remove-skill" onclick="removeSkillRow(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endforeach
            </div>

            {{-- Add More Skills Button --}}
            <div class="mb-4">
                <button type="button" id="add-skill" class="px-4 py-2 bg-green-600 text-white rounded">
                    <i class="fas fa-plus"></i> Add Another Skill
                </button>
            </div>

            {{-- Save Button --}}
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded btn btn-primary">
                <i class="fas fa-save"></i> Save Skills
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add new skill row
    document.getElementById('add-skill').addEventListener('click', function() {
        const wrapper = document.getElementById('skills-wrapper');
        const firstRow = wrapper.querySelector('.skill-row');
        
        if (firstRow) {
            // Clone the first row and reset its values
            const clone = firstRow.cloneNode(true);
            // Reset all select elements in the cloned row
            clone.querySelectorAll('select').forEach(select => {
                select.selectedIndex = 0;
            });
            wrapper.appendChild(clone);
        } else {
            // Fallback: create a new row from scratch
            const skillRow = document.createElement('div');
            skillRow.className = 'skill-row flex gap-3 mb-3';
            
            skillRow.innerHTML = `
                <select name="skills[]" class="border rounded p-2 w-1/2 form-control" required>
                    <option value="">Select a skill</option>
                    @if(isset($allSkills))
                        @foreach($allSkills as $skill)
                            <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                        @endforeach
                    @endif
                </select>
                <select name="levels[]" class="border rounded p-2 w-1/3 form-control">
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                    <option value="expert">Expert</option>
                </select>
                <button type="button" class="px-2 py-1 bg-red-500 text-white rounded remove-skill" onclick="removeSkillRow(this)">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            wrapper.appendChild(skillRow);
        }
    });
});

// Remove skill row
function removeSkillRow(button) {
    const skillRows = document.querySelectorAll('.skill-row');
    if (skillRows.length > 1) {
        button.closest('.skill-row').remove();
    } else {
        alert('You must have at least one skill row.');
    }
}
</script>
@endsection