@if ($currentStep == 4)

 <div wire:loading.flex wire:target="saveExtra"
            class="position-fixed top-0 start-0 w-100 h-100 justify-content-center align-items-center"
            style="background: rgba(255,255,255,0.7); z-index: 9999;">

            <div class="text-center">
                <img src="{{ asset('uploads/general/loading.gif') }}" alt="Saving..." style="width:80px;">
                <p class="mt-2 mb-0">Saving...</p>
            </div>
        </div>


    <div class="tab-pane fade show active">
        <form wire:submit.prevent="saveExtra">
            {{-- Social Media Section --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Social Media Links</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($socialMediaPlatforms as $platform)
                            <div class="col-md-6 mb-3">
                                <label for="social_{{ $platform->id }}" class="form-label">
                                    <i class="bi bi-{{ strtolower($platform->name) }}"></i>
                                    {{ ucfirst($platform->name) }}
                                </label>
                                <input type="text" class="form-control" wire:model="social_media.{{ $platform->id }}"
                                    placeholder="https://{{ strtolower($platform->name) }}.com/yourprofile">
                            </div>
                        @endforeach
                    </div>

                    @if ($socialMediaPlatforms->isEmpty())
                        <p class="text-muted">No social media platforms available.</p>
                    @endif
                </div>
            </div>

            {{-- Working Hours Section --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Working Hours</h5>
                </div>
                <div class="card-body">
                    @foreach ($days as $dayIndex => $day)
                        <div class="row mb-3 align-items-center working-hour-row" wire:key="day-{{ $dayIndex }}">
                            <div class="col-md-2">
                                <strong>{{ $day }}</strong>
                            </div>

                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        wire:model.live="working_hours.{{ $dayIndex }}.is_closed"
                                        wire:change="toggleDayClosed({{ $dayIndex }})"
                                        id="closed_{{ $dayIndex }}">
                                    <label class="form-check-label" for="closed_{{ $dayIndex }}">Closed</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        wire:model.live="working_hours.{{ $dayIndex }}.is_24_7"
                                        wire:change="toggleDay247({{ $dayIndex }})"
                                        id="is_24_7_{{ $dayIndex }}">
                                    <label class="form-check-label" for="is_24_7_{{ $dayIndex }}">24/7</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small">Open Time</label>
                                <select wire:model="working_hours.{{ $dayIndex }}.open_time" class="form-control"
                                    @if ($working_hours[$dayIndex]['is_closed'] || $working_hours[$dayIndex]['is_24_7']) disabled @endif>
                                    @for ($h = 0; $h < 24; $h++)
                                        @for ($m = 0; $m < 60; $m += 30)
                                            @php
                                                $time24 = sprintf('%02d:%02d', $h, $m);
                                                $time12 = date('h:i A', strtotime($time24));
                                            @endphp
                                            <option value="{{ $time24 }}">{{ $time12 }}
                                            </option>
                                        @endfor
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small">Close Time</label>
                                <select wire:model="working_hours.{{ $dayIndex }}.close_time" class="form-control"
                                    @if ($working_hours[$dayIndex]['is_closed'] || $working_hours[$dayIndex]['is_24_7']) disabled @endif>
                                    @for ($h = 0; $h < 24; $h++)
                                        @for ($m = 0; $m < 60; $m += 30)
                                            @php
                                                $time24 = sprintf('%02d:%02d', $h, $m);
                                                $time12 = date('h:i A', strtotime($time24));
                                            @endphp
                                            <option value="{{ $time24 }}">{{ $time12 }}
                                            </option>
                                        @endfor
                                    @endfor
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="saveExtra">
                    <i class="bi bi-check-circle"></i> {{ $mode == 'create' ? 'Complete' : 'Update' }} 
                </span>
                <span wire:loading wire:target="saveExtra">Completing...</span>
            </button>
        </form>
    </div>
@endif
