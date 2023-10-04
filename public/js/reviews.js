// displayMyReviews();


// var edit_review = document.getElementsByClassName("review");
// console.log(edit_review);

// for (var i = 0; i < edit_review.length; i++) {
//     edit_review[i].addEventListener("click", function() {
//         window.location.href = "/my-reviews/edit";
//     });
// }

// function displayMyReviews(response) {
//     const review_box_container = document.getElementById("rl1");
//     review_box_container.innerHTML = '';

//     for (var i = 0; i < 4; i++) {
//         const review = document.createElement("div");
//         review.className = "review"
//         review.innerHTML = `
//             <div class="profile-picture">
//                 <img src="$profilePicturePath">
//             </div>
//             <div class="review-details">
//                 <h6>
//                     $name
//                     <span class="review-date">
//                         $dateCreate
//                         $dateUpdate
//                     </span>
//                 </h6>
//                 <div class="review-stars-container">$starsHtml</div>
//                 <p>$reviewText</p>
//             </div>
//         `
//         //`<td>${response.name}</td><td>${response.user_input}</td><td>${response.output}</td>`;
//         review_box_container.appendChild(review);
//     }
// }


// var save_review = document.getElementById("save");

// save_review.addEventListener('click', function() {
    
// })

document.addEventListener("DOMContentLoaded", function () {
    const saveButton = document.querySelector('#save');
    saveButton.addEventListener('click', function (e) {
        e.preventDefault();
        handleOpen('#confirm-edit-modal');
    });

    const deleteButton = document.querySelector('#delete');
    deleteButton.addEventListener('click', function (e) {
        e.preventDefault();
        handleOpen('#confirm-delete-modal');
    });

    const confirmEditButton = document.querySelector('#confirm-edit-btn');
    confirmEditButton.addEventListener('click', function (e) {
        console.log("b")
        e.preventDefault();
        // const form = document.querySelector("#profile-form");
        // submitForm(form, "/profile/edit", function (responseText) {
        //     window.location.href = "/profile"
        // })
        handleClose('#confirm-edit-modal');
    });

    const confirmDeleteButton = document.querySelector('#confirm-delete-btn');
    confirmDeleteButton.addEventListener('click', function (e) {
        e.preventDefault();
        // const xhr = new XMLHttpRequest();
        // const url = '/profile/delete';
        // xhr.open('DELETE', url, true);
        // xhr.onreadystatechange = function () {
        //     if (xhr.readyState === 4) { // Check if the request is complete
        //         if (xhr.status === 200) {
        //             window.location.href = '/';
        //         } else {
        //             alert('Failed to delete account');
        //         }
        //     }
        // };
        // xhr.send();
    });
});