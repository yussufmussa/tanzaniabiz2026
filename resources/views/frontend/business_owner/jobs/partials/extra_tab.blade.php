<div class="tab-pane fade" id="extra" role="tabpanel">
    <form id="extraForm">
        @csrf

        {{-- Working Hours Section --}}
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
                            <input type="url" class="form-control" id="social_{{ $platform->id }}"
                                name="social_media[{{ $platform->id }}]"
                                placeholder="https://{{ strtolower($platform->name) }}.com/yourprofile"
                                value="{{ $businessSocialMedia[$platform->id] ?? '' }}">
                        </div>
                    @endforeach
                </div>

                @if ($socialMediaPlatforms->isEmpty())
                    <p class="text-muted">No social media platforms available. Please
                        contact administrator.</p>
                @endif
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Working Hours</h5>
            </div>
            <div class="card-body">
                @foreach ($days as $dayIndex => $day)
                    @php $workingHour = $workingHours[$dayIndex] ?? null; @endphp

                    <div class="row mb-3 align-items-center working-hour-row">
                        <div class="col-md-2">
                            <strong>{{ $day }}</strong>
                        </div>

                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input day-closed-check" type="checkbox"
                                    name="working_hours[{{ $dayIndex }}][is_closed]" id="closed_{{ $dayIndex }}"
                                    value="1" @checked($workingHour && $workingHour['is_closed'] ?? false)>
                                <label class="form-check-label" for="closed_{{ $dayIndex }}">Closed</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input day-24-7-check" type="checkbox"
                                    name="working_hours[{{ $dayIndex }}][is_24_7]"
                                    id="is_24_7_{{ $dayIndex }}" value="1" @checked($workingHour && $workingHour['is_24_7'] ?? false)>
                                <label class="form-check-label" for="is_24_7_{{ $dayIndex }}">24/7</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small">Open Time</label>
                            <select name="working_hours[{{ $dayIndex }}][open_time]" class="form-control open-time"
                                @disabled($workingHour && (($workingHour['is_closed'] ?? false) || ($workingHour['is_24_7'] ?? false)))>
                                @for ($h = 0; $h < 24; $h++)
                                    @for ($m = 0; $m < 60; $m += 30)
                                        @php
                                            $time24 = sprintf('%02d:%02d', $h, $m);
                                            $time12 = date('h:i A', strtotime($time24));
                                        @endphp
                                        <option value="{{ $time24 }}" @selected(($workingHour['open_time'] ?? '') == $time24)>
                                            {{ $time12 }}
                                        </option>
                                    @endfor
                                @endfor
                            </select>

                        </div>

                <div class="col-md-3">
                    <label class="form-label small">Close Time</label>
                        <select name="working_hours[{{ $dayIndex }}][close_time]" class="form-control close-time"
                        @disabled($workingHour && (($workingHour['is_closed'] ?? false) || ($workingHour['is_24_7'] ?? false)))>
                        @for ($h = 0; $h < 24; $h++)
                            @for ($m = 0; $m < 60; $m += 30)
                                @php
                                    $time24 = sprintf('%02d:%02d', $h, $m);
                                    $time12 = date('h:i A', strtotime($time24));
                                @endphp
                                <option value="{{ $time24 }}" @selected(($workingHour['close_time'] ?? '') == $time24)>
                                    {{ $time12 }}
                                </option>
                            @endfor
                        @endfor
                    </select>
                </div>

                <input type="hidden" name="working_hours[{{ $dayIndex }}][day_of_week]"
                    value="{{ $dayIndex }}">
            </div>
                @endforeach

            </div>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Complete Listing
        </button>
    </form>
</div>
