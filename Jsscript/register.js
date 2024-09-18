function calculateAge() {
    var dobInput = document.getElementById("dob").value;
    if (!dobInput) {
        document.getElementById("age").value = "";
        return; // Stop further execution
    }
    var dob = new Date(dobInput);
    var today = new Date();
    if (dob >= today) {
        alert("Please enter a valid date of birth!");
        document.getElementById("dob").value = ""; // Clear invalid date
        document.getElementById("age").value = "";
        return; // Stop further execution
    }
    var age = today.getFullYear() - dob.getFullYear();
    var monthDiff = today.getMonth() - dob.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
        age--;
    }
    document.getElementById("age").value = age;
}

// Function to display error messages in the corresponding error div
document.querySelectorAll('input:not([type="date"]):not([type="number"])').forEach(function(input) {
    input.addEventListener('invalid', function(event) {
        event.preventDefault();
        var errorDiv = document.getElementById(this.id + 'Err');
        errorDiv.textContent = this.validationMessage;
        errorDiv.style.display = 'block'; // Show the error message div
    });
});

// Function to hide error messages after 2 seconds
function hideErrorMessages() {
    document.querySelectorAll('.error1, .error2, .error3, .error4, .error5, .error6').forEach(function(element) {
        element.textContent = '';
        element.style.display = 'none'; // Hide the error message div
    });
}

document.querySelectorAll('input:not([type="date"]):not([type="number"])').forEach(function(input) {
    input.addEventListener('invalid', function(event) {
        event.preventDefault();
        var errorDiv = document.getElementById(this.id + 'Err');
        errorDiv.textContent = this.validationMessage;
        errorDiv.style.display = 'block'; // Show the error message div
        clearTimeout(window.errorTimeout); // Clear any existing timeout
        window.errorTimeout = setTimeout(hideErrorMessages, 2000); // Set a new timeout
    });
});

// Function to hide error messages immediately when the input is valid
document.querySelectorAll('input:not([type="date"]):not([type="number"])').forEach(function(input) {
    input.addEventListener('input', function(event) {
        var errorDiv = document.getElementById(this.id + 'Err');
        if (this.validity.valid) {
            errorDiv.textContent = '';
            errorDiv.style.display = 'none'; // Hide the error message div
        }
    });
});
