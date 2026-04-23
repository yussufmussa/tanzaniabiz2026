{{-- 3. Working Hours --}}
<div class="bg-white rounded mb-4">
    <div class="jbd-01 px-4 py-4">
        <div class="jbd-details">
            <h5 class="ft-bold fs-lg">Working Hours</h5>
            <div class="Goodup-lot-wrap d-block mt-3">
                @php
                    $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    $currentDay = now()->dayOfWeekIso - 1;
                    $currentTime = now()->format('H:i:s');
                @endphp
                <table class="table table-borderless">
                    <tbody>
                        @foreach ($days as $index => $day)
                            @php
                                $hours = $business->workingHours->firstWhere('day_of_week', $index);
                                $isToday = $currentDay === $index;
                                $isOpenNow = false;
                                if ($isToday && $hours && !$hours->is_closed && !$hours->is_24_7) {
                                    $isOpenNow =
                                        $currentTime >= $hours->open_time && $currentTime <= $hours->close_time;
                                } elseif ($isToday && $hours?->is_24_7) {
                                    $isOpenNow = true;
                                }
                            @endphp
                            <tr class="{{ $isToday ? 'table-light fw-bold' : '' }}">
                                <th scope="row">{{ $day }}</th>
                                <td>
                                    @if (!$hours || $hours->is_closed)
                                        <span class="text-muted">Closed</span>
                                    @elseif($hours->is_24_7)
                                        Open 24/7
                                    @else
                                        {{ \Carbon\Carbon::parse($hours->open_time)->format('g:i A') }}
                                        -
                                        {{ \Carbon\Carbon::parse($hours->close_time)->format('g:i A') }}
                                    @endif
                                </td>
                                <td>
                                    @if ($isOpenNow)
                                        <span class="badge bg-success">Open now</span>
                                    @elseif($isToday && $hours && !$hours->is_closed)
                                        <span class="badge bg-danger">Closed now</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
