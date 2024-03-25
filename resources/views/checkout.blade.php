<!DOCTYPE html>
<html lang="en">

<head>
    <title>Checkout</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://js.stripe.com/v3/"></script>
    {{-- <script src="/js/stripe.js" defer></script> --}}
</head>

<body>

    <form id="payment-form">
        <div id="card-element">
            <!-- Elements will create input elements here -->
        </div>

        <!-- We'll put the error messages in this element -->
        <div id="card-errors" role="alert"></div>

        <button id="submit">Pay</button>
    </form>
    <script>
        var stripe = Stripe(
            env('STRIPE_KEY')
        );
        var elements = stripe.elements();
        var style = {
            base: {
                color: "#32325d",
            },
        };

        var card = elements.create("card", {
            style: style
        });
        card.mount("#card-element");
        card.addEventListener("change", function(event) {
            var displayError = document.getElementById("card-errors");
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = "";
            }
        });

        var form = document.getElementById("payment-form");
        form.addEventListener("submit", function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById("card-errors");
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    createStripeCharge(result.token.id);
                }
            });
        });

        function createStripeCharge(token) {
            fetch('/graphql', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        query: `
                        mutation ($source: String!, $order_id: ID!) {
                        createStripeCharge(source: $source, order_id: $order_id) {
                            success
                            message
                        }
                        }
                    `,
                        variables: {
                            source: token,
                            order_id: "6600c9f3bc3332e02c0a8962" // Example amount in cents ($20.00)
                        }
                    }),
                })
                .then(response => response.json())
                .then(data => console.log(data));
        }
    </script>
</body>

</html>
