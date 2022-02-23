$(document).ready(function() {

	// Hide checkoutBtn or submit button
	const upKey = getCookie("upKey");
	const upEvHash = getCookie("upEvHash");
	const upTicket = getCookie("upTicket");
	let checkoutBtnContainer = document.querySelector('#checkoutBtnContainer');

	if (checkoutBtnContainer) {
		if (upKey == "" || upEvHash == "" || upTicket == "") {
			checkoutBtnContainer.innerHTML = '<button class="btn btn-lg ticket_submit_btn py-3" id="submitDetailsBtn">Submit</button>';
		} else{
			checkoutBtnContainer.innerHTML = '<button class="btn btn-lg w-100 btn-success py-3" id="makePaymentBtn">Make Payment</button>';
		}
	}

	// Add user payment details when userPaymentDetails is submitted
	async function SaveUserPaymentDetails(formData)
	{
	    await fetch('../../backend/models/user.mod.php', {
	        method: 'POST',
	        body: formData,
	    })
	    .then(response => response.json())
	    .then(data => {
	        (data.code == "404") ? error_operation(data.msg) : success_operation(data.msg);
	        if (data.code == "200") { 
	        	// document.getElementById("userPaymentDetails").reset();
	        	document.getElementById('checkoutBtnContainer').innerHTML = '<button class="btn btn-lg w-100 btn-success py-3" id="makePaymentBtn">Make Payment</button>';
	        }
	    })
	    .catch(err => {
	        error_operation("Payment details was not submitted successfully.")
	    })
	}

	// save user payment details when submitDetailsBtn is clicked
	$(document).on("click", "#submitDetailsBtn", function(event) {
	    event.preventDefault();
		const pay_fname    = $("#pay_fname").val();
		const pay_lname    = $("#pay_lname").val();
		const pay_email    = $("#pay_email").val();
		const pay_phone    = $("#pay_phone").val();
		const pay_location = $("#pay_location").val();
		const eid          = $("#eid").val();
		const tp           = $("#tp").val();
	    
	    if (pay_fname == "" && pay_lname == "" && pay_email == "" && pay_phone == "") {
	        let msg = "All fields are mandatory";
	        error_operation(msg);
	        return false;
	    }
	    if (pay_fname == "") {
	        let msg = "Your first name is required";
	        error_operation(msg);
	        return false;
	    }
	    if (pay_lname == "") {
	        let msg = "Your last name is required";
	        error_operation(msg);
	        return false;
	    }
	    if (pay_email == "") {
	        let msg = "Please enter a valid email";
	        error_operation(msg);
	        return false;
	    }
	    if (pay_phone == "") {
	        let msg = "Your active phone number is required.";
	        error_operation(msg);
	        return false;
	    }

	    let formData = new FormData();
	    let action = 'save_user_payment_details';
	    formData.append("pay_fname", pay_fname);
	    formData.append("pay_lname", pay_lname);
	    formData.append("pay_email", pay_email);
	    formData.append("pay_phone", pay_phone);
	    formData.append("pay_location", pay_location);
	    formData.append("eid", eid);
	    formData.append("tp", tp);
	    formData.append("action", action);
	    SaveUserPaymentDetails(formData);
	});


    // console.clear();
});