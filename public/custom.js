$(document).ready(function () {
    $('#have_addon').on('change', function () {
        if ($(this).is(':checked')) {
            $('#addons-section').show();
        } else {
            $('#addons-section').hide();
            $('#addon-container').html('');
        }
    });
});

// Function to add a new addon input group
function addAddon() {
    const index = $('#addon-container .addon-group').length;

    const addonHtml = `
        <div class="addon-group row mb-2">
            <div class="col">
                <input name="addons[${index}][title]" class="form-control" placeholder="Addon Title" required>
            </div>
            <div class="col">
                <input name="addons[${index}][price]" type="number" step="0.01" class="form-control" placeholder="Addon Price" required>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-danger remove-addon">X</button>
            </div>
        </div>
    `;

    $('#addon-container').append(addonHtml);
}

// Reindex all addon input names when one is removed
$(document).on('click', '.remove-addon', function () {
    $(this).closest('.addon-group').remove();
    reindexAddons();
});

function reindexAddons() {
    $('#addon-container .addon-group').each(function (i, group) {
        $(group).find('input').each(function () {
            if ($(this).attr('name').includes('[title]')) {
                $(this).attr('name', `addons[${i}][title]`);
            }
            if ($(this).attr('name').includes('[price]')) {
                $(this).attr('name', `addons[${i}][price]`);
            }
        });
    });
}
