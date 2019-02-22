var app = {

	initialize: function() {
		app.renderItemsCheckout();
	},

	renderItemsCheckout: function() {

		if (app.supportLocalStorage()) {
	        	
        	// Checks if cartArray already exists
        	if (localStorage.getItem("cartArray") != null) {

        		// cartArray already exists

        		// get cartArray from local storage 
        		var cartArrayString = localStorage.getItem("cartArray");

        		// parse cartArray so that we can manipulate it
        		var cartArray = JSON.parse(cartArrayString);

        		var total = 0;

        		var itemsArrayPaypal = [];

        		for (var i = 0; i < cartArray.length; i++) {

        			var subTotal = parseInt(cartArray[i].quantity) * parseInt(cartArray[i].price);
        			var total = total + subTotal;

        			var item = '<tr>' +
        						  '<td><img src="' + cartArray[i].imgUrl + '" height="80px"></td>' +		
					              '<td>' + cartArray[i].title + '</td>' +
					              '<td>' + cartArray[i].quantity + '</td>' +
					              '<td>$ ' + cartArray[i].price + '</td>' +
					              '<td>$ ' + subTotal + '</td>' +
					            '</tr>';

					var itemPaypal = {
										name: cartArray[i].title,
                                      	unit_amount: {
                                        	currency_code: 'MXN',
                                        	value: cartArray[i].price,
                                      	},
                                      	quantity: cartArray[i].quantity
                                    };

					$('#tbody-items').append(item);

					itemsArrayPaypal.push(itemPaypal);

        		}

        		var totalItem = '<tr>' +
        						  '<td></td>' +		
					              '<td></td>' +
					              '<td></td>' +
					              '<td><strong>TOTAL</strong></td>' +
					              '<td><strong>$ ' + total + '</strong></td>' +
					            '</tr>';

				$('#tbody-items').append(totalItem);

				app.renderPaypalButton(total,itemsArrayPaypal);

        	} else {

        		// cartArray does NOT exist yet

        		console.log("You don't have anything in the cart");
        	}

        } else {
        	alert("Ups! This browser does not support local storage. Please try with one of the following: Chrome,Firefox,Internet Explorer,Safari,Opera");
        }

	},

	renderPaypalButton: function(amountTotal,itemsArray) {

	var CREATE_ORDER_URL  = '../server_services/create-order.php';
    var CAPTURE_ORDER_URL = '../server_services/capture-order.php';

    paypal.Buttons({

        createOrder: function(data, actions) {
            
			var transactionsObject = {
	            amount: { 
	              currency_code: 'MXN', 
	              value: amountTotal,
	              breakdown: {
	                item_total: {
	                  currency_code: 'MXN',
	                  value: amountTotal
	                }
	              }
	            },
	            items: itemsArray
         	}

         	console.log(JSON.stringify(transactionsObject));

            return  fetch(CREATE_ORDER_URL, {
                    method: "POST",
                    mode: "same-origin",
                    credentials: "same-origin",
                    body: JSON.stringify({
                      "transactions": transactionsObject
                    }),
                    headers:{
                      "Content-Type": "application/json"
                    }
                  }).then(function(res) {
                      return res.json();
                  }).then(function(data) {
                      console.log(data);
                      return data.orderID;
                  });

        },

        onApprove: function(data, actions) {

          console.log('**data:' + JSON.stringify(data));
          
          return  fetch(CAPTURE_ORDER_URL, {
                    method: "POST",
                    mode: "same-origin",
                    credentials: "same-origin",
                    body: JSON.stringify({
                      "orderID": data.orderID
                    }),
                    headers:{
                      "Content-Type": "application/json"
                    }
                  }).then(function(res) {
                    return res.json();
                  }).then(function(details) {
                      // Show a success message to the buyer
                      console.log('***Transaction completed by ' + details.payer.name.given_name + '! and ' + JSON.stringify(details));
                  	  //localStorage.removeItem("cartArray");
                      //window.location = "index.php";
                  });

        }
    }).render('#paypal-button-container');

	},

	supportLocalStorage: function() {
		if(typeof(Storage) !== "undefined") {
			return true;
		} else {
			return false;
		}

	}

}

app.initialize();