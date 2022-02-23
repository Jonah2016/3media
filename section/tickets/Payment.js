$(document).ready(function() {

	// Add user payment details when makeTicketPayment is submitted
	async function makeTicketPayment(formData)
	{
	    await fetch('../../backend/models/payments.mod.php', {
	        method: 'POST',
	        body: formData,
	    })
	    .then(response => response.json())
	    .then(data => {
	        if (data.code == "404") {
	        	Swal.fire({
	        	    title: data.msg,
	        	    icon: 'danger',
	        	    showCancelButton: false,
	        	    confirmButtonColor: '#3085d6',
	        	    confirmButtonText: 'OK'
	        	}).then((result) => {
	        	    if (result.isConfirmed) {
	        	        window.history.back()
	        	    }
	        	})
	        } else {
	        	Swal.fire({
	        	    title: data.msg,
	        	    icon: 'success',
	        	    showCancelButton: false,
	        	    confirmButtonColor: '#3085d6',
	        	    confirmButtonText: 'OK'
	        	}).then((result) => {
	        	    if (result.isConfirmed) {
	        	        let redirect = data.url;
	        	        window.location = redirect;
	        	    }
	        	})
	        } 
	    })
	    .catch(err => {
	        let error = "Payment process was not successfully due to an unknown error."
	        Swal.fire({
	            title: error,
	            icon: 'success',
	            showCancelButton: false,
	            confirmButtonColor: '#3085d6',
	            confirmButtonText: 'OK'
	        }).then((result) => {
	            if (result.isConfirmed) {
	                window.history.back()
	            }
	        })
	    })
	}


	// Process payment when makePaymentBtn is clicked
	$(document).on("click", "#makePaymentBtn", function(event) {
	    event.preventDefault();
		const rid          = $("#rid").data('rid');
		const payFname    = $("#pay_fname").val();
		const payLname    = $("#pay_lname").val();
		const payEmail    = $("#pay_email").val();
		const payPhone    = $("#pay_phone").val();
		const payLocation = $("#pay_location").val();
	    
	    if (payFname == "" && payLname == "" && payEmail == "" && payPhone == "") {
	        let msg = "All fields are mandatory";
	        error_operation(msg);
	        return false;
	    }
	    if (payFname == "") {
	        let msg = "Your first name is required.";
	        error_operation(msg);
	        return false;
	    }
	    if (payFname != "" && payFname.length > 30) {
	        let msg = "Your first name should not be more than 30 characters.";
	        error_operation(msg);
	        return false;
	    }
	    if (payLname == "") {
	        let msg = "Your last name is required.";
	        error_operation(msg);
	        return false;
	    }
	    if (payLname != "" && payLname.length > 30) {
	        let msg = "Your last name should not be more than 30 characters.";
	        error_operation(msg);
	        return false;
	    }
	    if (payEmail == "") {
	        let msg = "Please enter a valid email. This is required.";
	        error_operation(msg);
	        return false;
	    }
	    if (payPhone == "") {
	        let msg = "Your active phone number is required.";
	        error_operation(msg);
	        return false;
	    }
	    if (payPhone != "" && payPhone.length > 15) {
	        let msg = "Your phone number should not be more than 15 characters.";
	        error_operation(msg);
	        return false;
	    }

	    let formData = new FormData();
	    let action = 'initialize_payment';
	    formData.append("payFname", payFname);
	    formData.append("payLname", payLname);
	    formData.append("payEmail", payEmail);
	    formData.append("payPhone", payPhone);
	    formData.append("payLocation", payLocation);
	    formData.append("rid", rid);
	    formData.append("action", action);
	    makeTicketPayment(formData);
	});




    // console.clear();
});