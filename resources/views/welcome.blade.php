<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="app.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Durian Pay</title>
</head>

<body>
    <form action="/" method="post">
        @csrf
        <div class="container-fluid">
            <div class="row"></div>
            <div class="row">
                <aside class="col-lg-9">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-borderless table-shopping-cart">
                                <thead class="text-muted">
                                    <tr class="small text-uppercase">
                                        <th scope="col">Product</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $item)
                                        <tr>
                                            <td>
                                                <figure class="itemside align-items-center">
                                                    <div class="aside">
                                                        <img src="{{ $item['image'] }}" alt="product image"
                                                            class="img-sm" srcset="">
                                                    </div>
                                                    <figcaption class="info"> <a href="#"
                                                            class="title text-dark">{{ $item['name'] }}</a>
                                                    </figcaption>
                                                </figure>
                                                <input type="hidden" name="product" value="{{ $item['name'] }}">
                                            </td>
                                            <td>
                                                <input type="number" name="qty" id="qty" class="form-control"
                                                    value="{{ $item['quantity'] }}">
                                            </td>
                                            <td>
                                                <div class="price-wrap">
                                                    <var class="price">{{ $item['price'] }}</var>
                                                    <input type="hidden" name="price" id="price"
                                                        value="{{ $item['price'] }}">

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </aside>
                <aside class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <dl class="dlist-align">
                                <dt>Total</dt>
                                <dd class="text-right text-dark b ml-3">
                                    <strong id="tot">0</strong>
                                </dd>
                                <input type="hidden" name="total" id="total">
                            </dl>
                            <button type="submit" class="btn btn-out btn-primary btn-square btn-main">Make
                                Purchase</button>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </form>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    $('#qty').on('change', () => {
        const qty = parseInt($('#qty').val())
        const price = parseInt($('#price').val())
        const total = qty * price;
        $('#tot').text(total)
        $('#total').val(total)
    })
</script>

</html>
