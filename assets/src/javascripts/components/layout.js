export default (function() {
    $('.btn-section').on('mouseover', function () {
        let sectionTitle = $(this).data('title');
        $('.app-banner-description').find('.container').text(sectionTitle);
    });
    $('.btn-section').on('mouseleave', setBannerDescription);

    function setBannerDescription() {
        let sectionTitle = $('.btn-section.active').data('title');
        $('.app-banner-description').find('.container').text(sectionTitle);
    }
    setBannerDescription();
})();