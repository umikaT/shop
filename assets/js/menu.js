document.addEventListener("DOMContentLoaded", function() {
    const userIcon = document.getElementById("user");
    const userPanel = document.getElementById("userPanel");

    if (userIcon && userPanel) {
        userIcon.addEventListener("click", function(e) {
            e.preventDefault();
            userPanel.style.display = userPanel.style.display === "block" ? "none" : "block";
        });

        // zamykanie panelu po kliknięciu poza nim
        document.addEventListener("click", function(e) {
            if (!userPanel.contains(e.target) && !userIcon.contains(e.target)) {
                userPanel.style.display = "none";
            }
        });
    }
});
