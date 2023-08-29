$(document).ready(function() {
    $("#employeeId").on("input", function() {
        var employeeId = $(this).val();
        // jQuery('#name').empty();
        // jQuery('#depart').empty();
        // jQuery('#location').empty();
        // alert(employeeId);
        $.ajax({
            url: "/server_script",
            method: "GET",
            data: {
                employeeId: employeeId
            },
            dataType: "json",
            success: function(data) {
                $("#name").val(data.first_name);
                if (data.department) {
                    $("#depart").val(data.department.name);
                } else {
                    $('#depart').val("");
                }
                if (data.location) {

                    $("#location").val(data.location.name);
                } else {
                    $("#location").val("");
                }
            }
        });
    });
});

//end showing asset according field

$(document).ready(function() {
    $('#assetSelect').hide();
    $('#addasset').on("click", function() {
        $('#assetSelect').show();
    });
});

jQuery(document).ready(function() {
    jQuery('#assettype').change(function() {
        let assettypeId = jQuery(this).val();
        // alert(assettypeId);
        jQuery('#asset').empty();

        if (assettypeId) {
            jQuery.ajax({
                url: '/get-asset-type/' + assettypeId,
                type: 'POST',
                data: 'assettypeId' + assettypeId + '&_token={{ csrf_token() }}',
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                success: function(data) {
                    jQuery('#asset').append('<option value="">Select Asset</option>');
                    jQuery.each(data.assets, function(key, value) {
                        jQuery('#asset').append('<option value="' + value.id +
                            '">' + value.name + '</option>');
                    });
                    jQuery('#asset').trigger('change');
                }
                
            });
            
        }
    });
});
// Ajax for Asset and Asset Type

$(document).ready(function() {
    $('#draggableMultiple,#CardChange').hide();

    var selectedCards = {}; // Object to store selected card IDs

    function updateSelectedCards(cardId, isSelected) {
        if (isSelected) {
            selectedCards[cardId] = true;
        } else {
            delete selectedCards[cardId];
        }
    }

    // Function to render asset cards
    function renderAssetCards(assets) {
        var assetDetailsContainer = $('#assetdetails');
        $('#draggableMultiple').show();
        assetDetailsContainer.empty();

        $.each(assets, function(index, asset) {
            var allbrand = asset.brand;
            var isSelected = selectedCards[asset.id];
            var deselectButton = isSelected ? '<div class="deselect-button"></div>' : '';
            var assetCard = `
                <div class="col-md-3">
                    <div class="card change-card ${isSelected ? 'selected' : ''}" data-card-id="${asset.id}">
                        <div class="card-body">
                            <h5 class="card-title card-text p-2">${asset.product_info}</h5>
                            <p class="card-subtitle mb-2">${allbrand ? 'Brand: <span class="text-muted">' + allbrand.name + '</span>' : 'Liscence Number: <span class="text-muted">' + (asset.liscence_number || 'N/A')}</span></p>
                            <p class="card-subtitle mb-2">${allbrand ? 'Serial Number: <span class="text-muted">' + (asset.brandmodel.name || 'N/A') + '</span>' : 'Configuration: <span class="text-muted">' + (asset.configuration || 'N/A')}</span></p>
                            <p class="card-subtitle mb-2">Price: <span class="text-muted">${asset.price}</span></p>
                            <input type="hidden" value="${asset.id}" name=cardId[] />
                            ${deselectButton}
                        </div>
                    </div>
                </div>
            `;
            assetDetailsContainer.append(assetCard);
        });
    }

    $('#asset').change(function() {
        var assetId = $(this).val();
        if (assetId) {
            $.ajax({
                type: "POST",
                url: "/get-asset-all-details/" + assetId,
                data: {
                    _token: "{{ csrf_token() }}",
                    _cache: new Date().getTime() // Add a cache-busting parameter
                },
                success: function(response) {
                    renderAssetCards(response);
                }
            });
        }
    });

    $(document).on("click", ".change-card", function() {
        var card = $(this);
        var cardId = card.data("card-id");

        if (selectedCards[cardId]) {
            updateSelectedCards(cardId, false); // Update selectedCards object
            card.removeClass("selected");
            card.find(".deselect-button").remove();
        } else {
            updateSelectedCards(cardId, true); // Update selectedCards object
            card.addClass("selected");
            card.find(".card-body").append('<div class="deselect-button"></div>');
        }
    });

    $(document).on("click", ".deselect-button", function() {
        var card = $(this).closest(".change-card");
        var cardId = card.data("card-id");

        updateSelectedCards(cardId, false); // Update selectedCards object
        card.removeClass("selected");
        $(this).remove();
    });
    const selectedAssetCards = {}; // Object to store selected asset cards

    // Function to update selected asset cards and session storage
    function updateSelectedAssetCards(cardId, isSelected) {
        if (isSelected) {
            selectedAssetCards[cardId] = true;
        } else {
            delete selectedAssetCards[cardId];
        }

        // Update session storage with selected asset cards
        sessionStorage.setItem('selectedAssetCards', JSON.stringify(selectedAssetCards));
    }

    // Function to render selected asset cards in the modal summary
    function renderSelectedAssetCards() {
        const summaryContainer = $('#selected-assets-summary-modal');
        summaryContainer.empty();
        var selectedCards = JSON.parse(sessionStorage.getItem('selectedAssetCards'));
        if (selectedCards && selectedCards.selectedAssets) {
        var selectedAssetIds = selectedCards.selectedAssets;
        $.each(selectedAssetCards, function(cardId, isSelected) {
            if (isSelected) {
                const assetCardHtml = $(`.change-card[data-card-id="${cardId}"]`).prop('outerHTML');
                summaryContainer.append(assetCardHtml);
            }
        });
    }
    }

    // Update selected asset cards when a card is clicked
    $(document).on("click", ".change-card", function() {
        const cardId = $(this).data("card-id");
        const isSelected = selectedAssetCards[cardId];
        updateSelectedAssetCards(cardId, !isSelected);
        $(this).toggleClass("selected", !isSelected);
    });

    // Show selected asset cards in the modal summary when "Next" button is clicked
    $('#next-assets').click(function(){
        renderSelectedAssetCards();
        $('#assetSummaryModal').modal('show');
    });

    // Update the modal summary when the modal is shown
    $('#assetSummaryModal').on('show.bs.modal', function() {
        renderSelectedAssetCards();
    });
});

// Asset and asset type jquery

document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector(".f1");
    const steps = form.querySelectorAll(".card");
    const nextButtons = form.querySelectorAll("[data-next]");
    const prevButtons = form.querySelectorAll("[data-prev]");

    nextButtons.forEach(button => {
        button.addEventListener("click", function() {
            const currentStep = button.closest(".card");
            const nextStepId = button.getAttribute("data-next");
            const nextStep = form.querySelector(`#${nextStepId}`);

            // Store current step data in session storage
            storeStepData(currentStep);

            // Show the next step
            currentStep.style.display = "none";
            nextStep.style.display = "block";
        });
    });

    prevButtons.forEach(button => {
        button.addEventListener("click", function() {
            const currentStep = button.closest(".card");
            const prevStepId = button.getAttribute("data-prev");
            const prevStep = form.querySelector(`#${prevStepId}`);

            // Store current step data in session storage
            storeStepData(currentStep);

            // Show the previous step
            currentStep.style.display = "none";
            prevStep.style.display = "block";
        });
    });

    form.addEventListener("submit", function(event) {
        event.preventDefault();
        // Store data from the last step
        storeStepData(steps[steps.length - 1]);

        // Submit the form
        form.submit();
    });

    function storeStepData(step) {
        const inputs = step.querySelectorAll("input, select, textarea");
        const data = {};

        inputs.forEach(input => {

            data[input.name] = input.value;
        });
        const statusInput = step.querySelector("[name='status']");
        if (statusInput) {
            data["status"] = statusInput.value;
        }

        // Store the data in session storage
        sessionStorage.setItem(step.id, JSON.stringify(data));

    }
});
// storage send

$(document).ready(function() {
    const selectedAssetCards = {}; // Object to store selected asset cards

    // Function to update selected asset cards and session storage
    function updateSelectedAssetCards(cardId, isSelected) {
        if (isSelected) {
            selectedAssetCards[cardId] = true;
        } else {
            delete selectedAssetCards[cardId];
        }

        // Update session storage with selected asset cards
       var check= sessionStorage.setItem('selectedAssetCards', JSON.stringify(selectedAssetCards));
       
       console.log(check);
    }

    // Function to render selected asset cards in the modal summary
    function renderSelectedAssetCards() {
        const summaryContainer = $('#selected-assets-summary-modal');
        summaryContainer.empty();

        $.each(selectedAssetCards, function(cardId, isSelected) {
            if (isSelected) {
                const assetCardHtml = $(`.change-card[data-card-id="${cardId}"]`).prop('outerHTML');
                summaryContainer.append(assetCardHtml);
            }
        });
    }

    // Update selected asset cards when a card is clicked
    $(document).on("click", ".change-card", function() {
        const cardId = $(this).data("card-id");
        const isSelected = selectedAssetCards[cardId];

        updateSelectedAssetCards(cardId, !isSelected);
        $(this).toggleClass("selected", !isSelected);
    });

    // Show selected asset cards in the modal summary when "Next" button is clicked
    $('#next-assets').click(function() {
        renderSelectedAssetCards();
        $('#assetSummaryModal').modal('show');
    });

    // Update the modal summary when the modal is shown
    $('#assetSummaryModal').on('show.bs.modal', function() {
        renderSelectedAssetCards();
    });
});

// modal open and close 

function showDiv() {
    var inputField = document.getElementById('employeeId');
    var div = document.getElementById('myDiv');

    if (inputField.value.trim() !== '') {
        div.style.display = 'block';
    } else {
        div.style.display = 'none';
    }
}

//step 1 form js