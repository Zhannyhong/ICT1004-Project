/*
var email = document.getElementById("email").value;
var username = document.getElementById("username").value;

var pwd = document.getElementById("pwd").value;
var pwd_confirm = document.getElementById("pwd_confirm").value;

function validateEmail() {
    if (this.value == "")
        alert("Email is required!");
    else if (!(/^[a-z0-9._%+-]+@[a-z0-9._%+-]+\.(com|edu|sg)$/.test(this.value)))
        alert("Invalid email format!");
};

function validateUsername() {
    if (this.value == "")
        alert("Username is required!");
    else if (this.value.length > 8)
        alert("Username contains more than 10 characters!");
    else if (!(/^[a-zA-Z0-9]+$/.test(this.value)))
        alert("Username contains non-alphanumeric characters!");
};

function validateFile() {
    if (this.files[0].size > 2097152) {
        alert("Profile picture cannot be more than 2MB!");
        this.value = "";
    }
    else if (!(/\.(jpe?g|png)$/.test(this.files[0].name)))
    {
        alert("File uploaded is not a JPEG, JPG, or PNG file!");
        this.value = "";
    }
};

function validatePwd() {
    if (this == "")
        alert("Password is required!");
    else if (this.length < 8)
        alert("Password must contain at least 8 characters!");
    else if (!(/^[0-9]+]$/.test(this)))
        alert("Password must contain at least 1 number!");
    else if (!(/^[A-Z]+]$/.test(this)))
        alert("Password must contain at least 1 uppercase letter!");
    else if (!(/^[a-z]+]$/.test(this)))
        alert("Password must contain at least 1 lowercase letter!");
};

function validatePwdCfm() {
    if (this == "")
        alert("Please confirm your password!");
    else if (pwd != pwd_confirm)
        alert("Passwords do not match!");
};
*/

var uploadField = document.getElementById("file_upload");
uploadField.onchange = function() {
    if (this.files[0].size > 2097152) {
        alert("Profile picture cannot be more than 2MB!");
        this.value = "";
    }
};
/*
$(document).ready(validateRegister());

function validateRegister()
{
    jQuery.validator.addMethod('filesize', function(value, element, param) {
        // param = size (in bytes)
        // element = element to validate (<input>)
        // value = value of the element (file name)
        return this.optional(element) || (element.files[0].size <= param);
    });

    $('#register').validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            username: {
                required: true,
                maxlength: 10
            },
            file_upload: {
                extension: "jpe?g|png",
                filesize: 2097152
            }
        },
        messages: {
            email: {
                required: "Email is required!",
                email: "Invalid email format!"
            },
            username: {
                required: "Username is required!",
                maxlength: "Username cannot have more than 10 characters!"
            },
            file_upload: {
                extension: "File uploaded is not a JPEG, JPG, or PNG file!",
                filesize: "File uploaded is more than 2MB!"
            }
        }
    });
};
*/

