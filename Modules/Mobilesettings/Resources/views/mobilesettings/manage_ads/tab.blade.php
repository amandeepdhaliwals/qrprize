<div class="row">
    <!-- Selected Ads Section -->
    <div class="col-md-6">
        <h4 class="text-center">{{ $type }}</h4>
        <div class="border p-3" id="selected-ads-{{ $adsMetaField }}" data-ads-meta-field="{{ $adsMetaField }}">
            @foreach($campaignAdsMeta as $meta)
                @if($meta->$adsMetaField)
                    <div class="d-flex justify-content-between border mb-2 p-2 bg-light">
                        <span>{{ $meta->advertisement->advertisement_name }} ({{ $meta->campaign->campaign_name }})</span>
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

    <!-- Campaigns and Advertisements Section -->
    <div class="col-md-6">
        <h4 class="text-center">Available Campaigns and Advertisements</h4>
        <div class="border p-3" id="campaign-ads-{{ $adsMetaField }}" data-ads-meta-field="{{ $adsMetaField }}">
            @foreach($campaigns as $campaign)
                <h5 class="mt-3">{{ $campaign->campaign_name }}</h5>
                @foreach($campaign->advertisements as $advertisement)
                    <div class="border mb-2 p-2 bg-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span>{{ $advertisement->advertisement_name }}</span>
                                @if($advertisement->media_type == 'image')
                                    <img src="{{ asset('storage/'.$advertisement->media_path) }}" alt="{{ $advertisement->title }}" class="img-fluid" />
                                @elseif($advertisement->media_type == 'video')
                                    <video width="320" height="240" controls>
                                        <source src="{{ asset('storage/'.$advertisement->media_path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                            </div>
                            <button class="btn btn-sm btn-primary add-ad" 
                                    data-cm-id="{{ $campaign->id }}" 
                                    data-ad-id="{{ $advertisement->id }}" 
                                    data-ads-meta-field="{{ $adsMetaField }}">
                                Add to {{ $type }}
                            </button>
                        </div>
                    </div>
                @endforeach
            @endforeach
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
        const target = $(`#selected-ads-${adsMetaField}`);
        const adElement = $(this).closest('.border');
        target.append(adElement);
        updateAdStatus(adId, cmId, adsMetaField, true);
    });

    $(document).off('click', '.remove-ad').on('click', '.remove-ad', function () {
        const adId = $(this).data('ad-id');
        const cmId = $(this).data('cm-id');
        const adsMetaField = $(this).data('ads-meta-field'); // Dynamically fetch the adsMetaField
        const target = $(`#campaign-ads-${adsMetaField}`);
        const adElement = $(this).closest('.border');
        target.append(adElement);
        updateAdStatus(adId, cmId, adsMetaField, false);
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
                   // location.reload();
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
