<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    		<script src="https://cdn.shopify.com/s/assets/external/pos_app.js"></script>
    		<script type="text/javascript">
			    ShopifyPOS.init({
			      apiKey: 'da9a830229b4eec97fbae34eab0781b9',
			      shopOrigin: 'https://pockeyt-test.myshopify.com',
			      debug: true
			    });

			    ShopifyPOS.ready(function(){
					  ShopifyPOS.fetchCart({
					  	success: function(cart) {
					  		cart.addProperties({
					  			'pockeyt_id': "123e4567-e89b-12d3-a456-426655440000"
					  		},{
					  			success: function(cart) {
					  				ShopifyPOS.flashNotice(cart);
					  			},
					  			error: function(errors) {
					  				ShopifyPOS.flashError(errors);
					  			}
					  		})
					  	},
					  	error: function(errors) {
					  		ShopifyPOS.flashError(errors);
					  	}
					  });


					});
			  </script>

        <title>Shopify</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Shopify
                </div>

                <div class="links">
                    
                </div>
            </div>
        </div>
    </body>
</html>