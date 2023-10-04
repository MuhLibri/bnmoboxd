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