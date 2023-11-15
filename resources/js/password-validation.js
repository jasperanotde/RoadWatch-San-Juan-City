document.addEventListener("DOMContentLoaded", function() {

var is_visible = false;

const seeElement = document.getElementById('see');
const inputElement = document.getElementById("password");

seeElement.addEventListener('click', function() {
    var input = document.getElementById("password");
    var see = document.getElementById("see");
    
    if(is_visible)
    {
        input.type = 'password';
        is_visible = false; 
        see.style.color='gray';
    }
    else
    {
        input.type = 'text';
        is_visible = true; 
        see.style.color='#262626';
    }
});

inputElement.addEventListener('input', function() {

    var inputValue = inputElement.value;
    var check0 = document.getElementById("check0");
    var check1 = document.getElementById("check1");
    var check2 = document.getElementById("check2");
    var check3 = document.getElementById("check3");
    var check4 = document.getElementById("check4");
    
    inputValue=inputValue.trim();
    document.getElementById("password").value=inputValue;
    //document.getElementById("count").innerText="Length : " + inputValue.length;

    if(inputValue.length <= 0){
        check0.style.color="red";
        check1.style.color="red";
        check2.style.color="red";
        check3.style.color="red";
        check4.style.color="red";
    }
    else {
        if(inputValue.length >= 5)
        {
            check0.style.color="green";
        }
        else
        {
            check0.style.color="red";
        }
        
        if(inputValue.length<=10)
        {
            check1.style.color="green";
        }
        else
        {
            check1.style.color="red"; 
        }
        
        if(inputValue.match(/[0-9]/i))
        {
            check2.style.color="green";
        }
        else
        {
            check2.style.color="red"; 
        }
        
        if(inputValue.match(/[^A-Za-z0-9-' ']/i))
        {
            check3.style.color="green";
        }
        else
        {
            check3.style.color="red"; 
        }
        
        if(inputValue.match(' '))
        {
            check4.style.color="red";
        }
        else
        {
            check4.style.color="green"; 
        }
    }

   
});

document.getElementById("phoneForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevents the form from submitting by default
    
    var password = document.getElementById("password").value;
    var checks = [
        password.length > 5,
        password.length < 10,
        /\d/.test(password), // Checks for at least one numerical character
        /[!@#$%^&*(),.?":{}|<>]/.test(password), // Checks for at least one special character
        !/\s/.test(password) // Checks for no spaces
    ];

    // Check if all criteria are met
    var isValid = checks.every(function(check) {
        return check;
    });

    // Check if all criteria are met
    var isValid = checks.every(function(check) {
        return check;
    });

    var errorMessage = document.getElementById("errorMessage");
    var errorMessageText = document.getElementById("errorMessageText");

    // Get the value of the contact number input
    var contactNumber = document.getElementById('contact_number').value;

    // Get the error message div
    var errorMessage = document.getElementById('errorMessage');

    if (isValid) {
    // Check if the contact number starts with '63'
        if (contactNumber.startsWith('63')) {
        // If it starts with '63', submit the form
        document.getElementById("phoneForm").submit();
        } else {
            // If it doesn't start with '63', display the error message
            errorMessage.style.display = 'block';
        }
    } else {
        // Password doesn't meet all criteria, show error message
        errorMessage.classList.remove("hidden");
        errorMessageText.textContent = "Password does not meet all criteria.";
    }
});

});