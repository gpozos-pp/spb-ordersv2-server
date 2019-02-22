<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Geenius Store</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <script src="https://www.paypal.com/sdk/js?currency=MXN&client-id=AdLP7TfHOHls5OU6jM-hxJtfJCJLF599FsAhkpCrkhKw5FOKNa1PrCJ8cbiyNurH97bM4T7Tf5OL5c_v"></script>

  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Geenius Store</a>
        </div>
      </div>
    </nav>

<div class="container">

      <div class="row">

        <div class="col-sm-6 col-md-4">
          <div class="thumbnail">
            <img src="https://parsefiles.back4app.com/dVVty0n8MrhMhTusZHskFKJADY2HmG17KWW2TpQ9/50876068c4ca956425418f217027a6ee_playera.jpg" alt="Tee">
            <div class="caption">
              <h3>Nike T-shirt</h3>
              <p>$198</p>
              <div id="paypal-button-1"></div>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-md-4">
          <div class="thumbnail">
            <img src="https://parsefiles.back4app.com/dVVty0n8MrhMhTusZHskFKJADY2HmG17KWW2TpQ9/258d80e16dcee0fb730dd4eea51507eb_sudadera.jpg" alt="Hoodie">
            <div class="caption">
              <h3>Hurley Hoodie</h3>
              <p>$490</p>
              <div id="paypal-button-2"></div>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-md-4">
          <div class="thumbnail">
            <img src="https://parsefiles.back4app.com/dVVty0n8MrhMhTusZHskFKJADY2HmG17KWW2TpQ9/25992aaddb3f59af3a7f2bdcf6b362af_converse.jpg" alt="Shoes">
            <div class="caption">
              <h3>Shoes</h3>
              <p>$400</p>
              <div id="paypal-button-3"></div>
            </div>
          </div>
        </div>
      </div>


    </div><!-- /.container -->

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript">

      var CREATE_ORDER_URL  = '../server_services/create-order.php';
      var CAPTURE_ORDER_URL = '../server_services/capture-order.php';

      // BUTTON 1  

      paypal.Buttons({

        createOrder: function(data, actions) {

          var transactionsObject = {
            amount: { 
              currency_code: 'MXN', 
              value: '198.00',
              breakdown: {
                item_total: {
                  currency_code: 'MXN',
                  value: '198.00'
                }
              }
            },
            items: [{
              name: 'T-Shirt',
              unit_amount: {
                currency_code: 'MXN',
                value: '198.00'
              },
              quantity: '1'
            }]
          }

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
                  });

        }

      }).render('#paypal-button-1');

      // BUTTON 2  

      paypal.Buttons({

        createOrder: function(data, actions) {

          var transactionsObject = {
            amount: { 
              currency_code: 'MXN', 
              value: '490.00',
              breakdown: {
                item_total: {
                  currency_code: 'MXN',
                  value: '490.00'
                }
              }
            },
            items: [{
              name: 'Hurley Hoodie',
              unit_amount: {
                currency_code: 'MXN',
                value: '490.00'
              },
              quantity: '1'
            }]
          }

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
                  });

        }

      }).render('#paypal-button-2');

      // BUTTON 3  

      paypal.Buttons({

        createOrder: function(data, actions) {

          var transactionsObject = {
            amount: { 
              currency_code: 'MXN', 
              value: '400.00',
              breakdown: {
                item_total: {
                  currency_code: 'MXN',
                  value: '400.00'
                }
              }
            },
            items: [{
              name: 'Shoes',
              unit_amount: {
                currency_code: 'MXN',
                value: '400.00'
              },
              quantity: '1'
            }]
          }

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
                  });

        }

      }).render('#paypal-button-3');


    </script>

  </body>
</html>
