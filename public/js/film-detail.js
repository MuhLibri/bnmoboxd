document.addEventListener("DOMContentLoaded", function () {
    const trailerButton = document.getElementById('watch-trailer-btn');
    trailerButton.addEventListener('click', function (e) {
        e.preventDefault();
        handleOpen('#trailer-container');
    });

    const closeTrailerButton = document.getElementById('close-trailer-btn');
    const videoPlayer = document.getElementById('video-player');
    closeTrailerButton.addEventListener('click', function (e) {
        e.preventDefault()
        videoPlayer.pause();
        handleClose('#trailer-container')
    });

    const addReviewButton = document.getElementById('add-review-btn');
    addReviewButton.addEventListener('click', function (e) {
        e.preventDefault();
        handleOpen('#create-review-modal');
    })

    const cancelReviewButton = document.getElementById('cancel-add-review-btn');
    cancelReviewButton.addEventListener('click', function (e) {
        e.preventDefault();
        handleClose('#create-review-modal');
    })

    const createReviewButton = document.getElementById('create-review-btn');
    const form = document.getElementById('create-review-form');
    createReviewButton.addEventListener('click', function (e) {
        e.preventDefault();
        submitForm(form, "/my-reviews", function (responseText) {
            location.reload();
        })
    })
})