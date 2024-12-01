<div class="container mt-4">
    <div class="row">
        <!-- Selected Ads Section -->
        <div class="col-md-6 mb-4">
            <h4 class="text-center">{{ $type }}</h4>
            <div class="border p-3 bg-light" id="selected-ads-{{ $adsMetaField }}" data-ads-meta-field="{{ $adsMetaField }}">
                @foreach($campaignAdsMeta as $meta)
                    @if($meta->$adsMetaField)
                        <div class="d-flex justify-content-between border mb-2 p-2">
                            <span>{{ $meta->advertisement->advertisement_name }} 
                                <br><small>({{ $meta->campaign->campaign_name }})</small>
                            </span>
                            <button class="btn btn-sm btn-danger remove-ad" 
                                    data-cm-id="{{ $meta->campaign_id }}" 
                                    data-ad-id="{{ $meta->advertisement_id }}" 
                                    data-ads-meta-field="{{ $adsMetaField }}">
                                Remove
                            </button>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        
        <!-- Campaign Ads Section -->
        <div class="col-md-6">
            <div class="row">
            @foreach($campaigns as $campaign)
            <h5 class="mt-3">{{ $campaign->campaign_name }}</h5>
            @foreach($campaign->advertisements as $advertisement)
                @php
                    $isAdded = $campaignAdsMeta->where('advertisement_id', $advertisement->id)
                                               ->where('campaign_id', $campaign->id)
                                               ->where($adsMetaField, true)
                                               ->isNotEmpty();
                @endphp
                <div class="border mb-2 p-2 bg-white">
                    <div class="d-flex justify-content-between">
                        <div>
            
                            <span>{{ $advertisement->advertisement_name }}</span>
                            @if($advertisement->video)
                            @if($advertisement->video->media_type == 'image')
                                <img src="{{ asset('storage/'.$advertisement->video->media) }}" alt="{{ $advertisement->advertisement_name }}" class="img-fluid" />
                            @elseif($advertisement->video->media_type == 'video')
                                <video width="150" height="100" controls>
                                    <source src="{{ asset('storage/'.$advertisement->video->media) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif($advertisement->video->media_type == 'youtube')
                                <iframe width="150" height="100" src="{{ $advertisement->video->media }}" frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen></iframe>
                            @elseif($advertisement->video->media_type == 'vimeo')
                                <iframe src="{{ $advertisement->video->media }}" width="150" height="100" frameborder="0" allowfullscreen></iframe>
                            @endif
                        @else
                            <p>Video not available</p>
                        @endif
                        </div>
                        @if($isAdded)
                            <button class="btn btn-sm btn-secondary" disabled>
                                Already Added
                            </button>
                        @else
                            <button class="btn btn-sm btn-primary add-ad" 
                                    data-cm-id="{{ $campaign->id }}" 
                                    data-ad-id="{{ $advertisement->id }}" 
                                    data-ads-meta-field="{{ $adsMetaField }}">
                                Add to {{ $type }}
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
            <!-- Display pagination links for advertisements -->
        
           @endforeach
            </div>
        </div>

        <!-- Pagination Links -->
        <div class="col-12 mt-4">
            {{ $campaigns->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


<script>
$(document).ready(function () {
    $(document).off('click', '.add-ad').on('click', '.add-ad', function () {
        const adId = $(this).data('ad-id');
        const cmId = $(this).data('cm-id');
        const adsMetaField = $(this).data('ads-meta-field'); // Dynamically fetch the adsMetaField
        updateAdStatus(adId, cmId, adsMetaField, 1);
    });

    $(document).off('click', '.remove-ad').on('click', '.remove-ad', function () {
        const adId = $(this).data('ad-id');
        const cmId = $(this).data('cm-id');
        const adsMetaField = $(this).data('ads-meta-field'); // Dynamically fetch the adsMetaField
        updateAdStatus(adId, cmId, adsMetaField, 0);
    });

    // Update advertisement status
    function updateAdStatus(adId, cmId, type, status) {
        $.ajax({
            url: "{{ route('backend.mobilesettings.update.ad.status') }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: { adId, cmId, type, status },
            success: function (response) {
                if (response.success) {
                    location.reload();
                    console.log('Advertisement status updated successfully.');
                } else {
                    console.error('Error updating advertisement status.');
                }
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }
});


</script>
