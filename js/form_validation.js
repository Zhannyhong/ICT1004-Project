
// Proactively ensures that the user does not upload pictures that are too large
var uploadField = document.getElementById("file_upload");
uploadField.onchange = function() {
    if (this.files[0].size > 2097152) {
        alert("Profile picture cannot be more than 2MB!");
        this.value = "";
    }
};

