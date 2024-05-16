
document.addEventListener("DOMContentLoaded", function() {
    // Select the login button
    const loginButton = document.querySelector(".DBloginButton");

    // Add click event listener to the login button
    loginButton.addEventListener("click", function() {
        // Redirect to the profile page
        window.location.href = "profile.php";
    });
});
