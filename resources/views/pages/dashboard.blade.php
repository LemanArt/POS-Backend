@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <?php
    use App\Models\User;
    use App\Models\Product;
    use App\Models\Order;
    use Illuminate\Support\Facades\DB;

    // $total_admin = User::where('roles', 'admin')->count();
    $total_admin = User::count();
    $total_product = Product::count();
    $total_order = Order::count();
    $orders = Order::select('transaction_time', 'total_price')->orderBy('transaction_time')->get();

    $labels = $orders->pluck('transaction_time')->toArray(); // sebelumnya 'order_date'
    $data = $orders->pluck('total_price')->toArray(); // sebelumnya 'total_amount'
    // Query untuk mendapatkan produk yang terjual beserta jumlahnya
    $sold_products = DB::table('order_items')->join('products', 'order_items.product_id', '=', 'products.id')->select('products.name', 'products.price', DB::raw('SUM(order_items.quantity) as quantity_sold'))->groupBy('order_items.product_id', 'products.name', 'products.price')->orderBy('quantity_sold', 'desc')->get();
    ?>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-dark-gray">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Users</h4>
                            </div>
                            <div class="card-body">
                                <?php echo $total_admin; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-soft-blue">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Products</h4>
                            </div>
                            <div class="card-body">
                                <?php echo $total_product; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-soft-green">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Orders</h4>
                            </div>
                            <div class="card-body">
                                <?php echo $total_order; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tambahkan bagian untuk menampilkan produk yang terjual -->
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Menu Terjual</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tr>
                                        <th>Menu</th>
                                        <th>Jumlah</th>
                                        <th>Pendapatan</th>
                                    </tr>
                                    @php
                                        $totalRevenue = 0;
                                    @endphp
                                    @foreach ($sold_products as $product)
                                        @php
                                            $revenue = $product->quantity_sold * $product->price;
                                            $totalRevenue += $revenue;
                                        @endphp
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->quantity_sold }}</td>
                                            <td>{{ 'Rp ' . number_format($product->quantity_sold * $product->price, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3">&nbsp;</td>
                                    <tr>
                                        <td colspan="2"><strong>Total Pendapatan :</strong></td>
                                        <td><strong>{{ 'Rp ' . number_format($totalRevenue, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Menu Terjual</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="productsChart" width="400" height="300" max-height= "350"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Mengambil data produk yang terjual dari PHP
            var products = @json($sold_products);

            // Mendefinisikan label dan data untuk grafik
            var productNames = [];
            var quantitiesSold = [];
            var fullProductNames = []; // Menyimpan nama lengkap produk

            products.forEach(function(product) {
                // Mendapatkan inisial dari setiap kata dalam nama produk
                var initials = product.name.match(/\b\w/g) || [];
                var acronym = initials.join('')
            .toUpperCase(); // Menggabungkan inisial untuk membentuk akronim

                // Menggunakan akronim sebagai nama produk atau nama singkat
                productNames.push(acronym); // Menambahkan jumlah terjual setelah akronim
                quantitiesSold.push(product.quantity_sold);
                fullProductNames.push(product.name); // Menyimpan nama lengkap produk
            });

            // Menggambar grafik menggunakan Chart.js
            var ctx = document.getElementById('productsChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: productNames,
                    datasets: [{
                        label: 'Jumlah Terjual',
                        data: quantitiesSold,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function(value, index, values) {
                                    return value
                                .toLocaleString(); // Menggunakan koma sebagai pemisah ribuan
                                }
                            }
                        }]
                    },
                    // maintainAspectRatio: false, // Menjadikan chart tidak mempertahankan rasio aspek
                    responsive: true, // Menjadikan chart responsif
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                // Mendapatkan indeks data yang dihover
                                var dataIndex = tooltipItem.index;
                                // Mengembalikan nama lengkap produk dari array nama produk
                                return fullProductNames[dataIndex];
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
