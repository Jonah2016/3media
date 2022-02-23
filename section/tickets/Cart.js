$(document).ready(function() {
    // check if cart isnt empty the trigger proceedto cart button
    load_proceed_to_cart_btn();
    function load_proceed_to_cart_btn() {
        const proceedToCartContainer = document.querySelector('#proceedToCartContainer');
        if (proceedToCartContainer) {
            const cart_not_empty = $("#proceedToCartContainer").data('cart_not_empty');
            if (cart_not_empty != 0 && cart_not_empty != "0" && cart_not_empty != "") {
                document.querySelector('#proceedToCartContainer').innerHTML = `<a class="btn btn-lg w-100 btn-success py-3" href="./ticket_checkout">Proceed to Cart</a>`;
            }
        }
    }

    // Add ticket to cart when addTicketToCart is submitted
    async function addTicketToCart(formData)
    {
        await fetch('../../backend/models/tickets.mod.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            // (data.code == "404") ? error_operation(data.msg) : success_operation(data.msg);
            if (data.code == "200") { 
                let total = data.cartTotal;
                document.getElementById(data.btnId).classList.remove('btn-dark');
                document.getElementById(data.btnId).classList.add('disabled');
                document.getElementById(data.btnId).classList.add('btn-secondary');
                document.querySelector('#cartTotalDisplay').innerText = total;
                document.querySelector('#proceedToCartContainer').innerHTML = `<a class="btn btn-lg w-100 btn-success py-3" href="./ticket_checkout">Proceed to Cart</a>`;
            } else {
                document.getElementById(data.btnId).classList.remove('disabled');
                document.getElementById(data.btnId).classList.remove('btn-secondary');
                document.getElementById(data.btnId).classList.add('btn-dark');
                document.querySelector('#proceedToCartContainer').innerHTML = "";
            }
        })
        .catch(err => {
            error_operation("Ticket could not be added to cart.")
        })
    }

    // Remove cart item when removeCartItem is submitted
    function removeCartItem(formData) {
        Swal.fire({
            title: 'Are you sure, you want to remove this item from your cart?',
            text: "Changes made are permanent!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../../backend/models/tickets.mod.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    (data.code == "404") ? error_operation(data.msg) : success_operation(data.msg);
                    location.reload(true)
                })
                .catch(err => {
                    error_operation("Cart item could not be removed.")
                })
            }
        })
    }

    // Empty cart when emptyCart is submitted
    function emptyCart(formData) {
        Swal.fire({
            title: 'Are you sure, you want to empty your cart?',
            text: "This action is permanent!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../../backend/models/tickets.mod.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    (data.code == "404") ? error_operation(data.msg) : success_operation(data.msg);
                    location.reload(true)
                })
                .catch(err => {
                    error_operation("Cart could not be emptied.")
                })
            }
        })
    }


    // onclick add items to cart
    $(document).on("click", ".addToCart", function(event) {
        event.preventDefault();
        const btnId      = $(this).attr('id');
        const trimName   = $("#"+btnId).data('trim_name');
        const ticketName = $("#"+btnId).data('tname');
        const eventCode  = $("#"+btnId).data('ecode');
        const eventName = $("#"+btnId).data('event_name');
        const ticketQty  = $('#qty_'+trimName).val();

        let formData = new FormData();
        let action = 'add_ticket_to_cart';
        formData.append("btnId", btnId);
        formData.append("ticketName", ticketName);
        formData.append("ticketQty", ticketQty);
        formData.append("eventCode", eventCode);
        formData.append("event_name", eventName);
        formData.append("action", action);
        addTicketToCart(formData);
    });
    // onclick remove item in cart
    $(document).on("click", ".removeCartItem", function(event) {
        event.preventDefault();
        const itemID = $(this).data('id');

        let formData = new FormData();
        let action = 'remove_item';
        formData.append("itemID", itemID);
        formData.append("action", action);
        removeCartItem(formData);
    });
    // onclick empty items in cart
    $(document).on("click", "#emptyCart", function(event) {
        event.preventDefault();
        let formData = new FormData();
        let action = 'empty_cart';
        formData.append("action", action);
        emptyCart(formData);
    });

    

});