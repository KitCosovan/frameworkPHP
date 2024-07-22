$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $("input#title").stringToSlug({
        getPut: 'input.slug'
    });

    $('.select2').select2();

    bsCustomFileInput.init();

    $('.summernote').summernote({
        height: 300
    })

    $('.del-item').on('click', function() {
        return confirm('Are you sure?');
    })

    $('.btn-copy').copyOnClick({
        confirmClass: "copy-confirmation",
        confirmText: "Copied",
        confirmTime: 3,
        confirmText: "<<%c>> from %i"
    })
})