@extends('layouts.web_public')
@section('content')
    <div class="breadcrumb__container">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="bi bi-house-door-fill"></i>
                            Home
                        </a>
                    </li>
                    <li class="breadcrumb-item " aria-current="page">
                        <a href="">
                            Thanh toán
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="pay__content">
        <div class="container">
            <form action="{{ route('order.add') }}" method="POST">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-6">
                        <div class="customer__container">
                            <div class="pay__header">
                                <h3>Thông tin khách hàng</h3>
                            </div>
                            <div class="customer__form">
                                <div class="form-group">
                                    <label for="customer__name">Họ tên (*)</label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                        name="customer_name" id="customer__name" value="{{ old('customer_name') }}">
                                    @error('customer_name')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="customer__phone">Số điện thoại (*)</label>
                                    <input type="text"
                                        class="form-control  @error('customer_phone') is-invalid @enderror"
                                        name="customer_phone" id="customer__phone" value="{{ old('customer_phone') }}">
                                    @error('customer_phone')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="customer__email">Địa chỉ Email (*)</label>
                                    <input type="text" class="form-control @error('customer_email') is-invalid @enderror"
                                        name="customer_email" id="customer__email" value="{{ old('customer_email') }}">
                                    @error('customer_email')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-address">
                                    <label for="customer__email">Địa chỉ (*)</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <select name="province_id" id="province"
                                                    class="form-control @error('province_id') is-invalid @enderror">
                                                    <option value="0">Chọn Tỉnh/ Thành phố</option>
                                                    @foreach ($provinces as $province)
                                                        <option value="{{ $province->province_id }}">
                                                            {{ $province->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('province_id')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <select name="ward_id" id="ward"
                                                    class="form-control @error('ward_id') is-invalid @enderror">
                                                    <option value="0">Chọn Phường/ Xã</option>
                                                </select>
                                                @error('ward_id')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <select name="district_id" id="district"
                                                    class="form-control @error('district_id') is-invalid @enderror">
                                                    <option value="0">Chọn Quận/ Huyện</option>
                                                </select>
                                                @error('district_id')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="text"
                                                    class="form-control @error('num_house') is-invalid @enderror"
                                                    name="num_house" placeholder="Số nhà, tên đường"
                                                    value="{{ old('num_house') }}">
                                                @error('num_house')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="customer__note">Ghi chú</label>
                                    <textarea name="customer_note" class="form-control" id="customer__note" cols="30" rows="5">
                                        {{-- {{ old('customer_note') }} --}}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="cart__container">
                            <div class="pay__header">
                                <h3>Thông tin đơn hàng</h3>
                            </div>
                            <div class="cart__info">
                                <table>
                                    <thead>
                                        <tr>
                                            <td>Sản phẩm</td>
                                            <td>Tổng</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach (Cart::content() as $row)
                                            <tr>
                                                <td>
                                                    {{ $row->name }} <strong> - Màu {{ $row->options->color }} x
                                                        {{ $row->qty }}
                                                    </strong>
                                                </td>
                                                <td> {{ number_format($row->total, 0, '', '.') }}đ</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                Tổng đơn hàng:
                                            </td>
                                            <td>{{ Cart::total() }}đ</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <ul id="payment_methods">
                                    <li>
                                        <input type="radio" id="direct-payment" name="payment_method"
                                            value="online-payment">
                                        <label for="direct-payment">Thanh toán online</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="payment-home" name="payment_method" value="payment-home"
                                            checked>
                                        <label for="payment-home">Thanh toán tại nhà</label>
                                    </li>
                                </ul>
                                <div class="place__order">
                                    <button class="btn__order">
                                        Đặt hàng
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
