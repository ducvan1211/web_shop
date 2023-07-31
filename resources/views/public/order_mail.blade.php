<div style="width:1170px;height:auto;padding:15px;margin:0px auto;background-color:#f2f2f2">
    <div class="adM">
    </div>
    <div class="adM">
    </div>
    <div class="adM">
    </div>
    <div>
        <div class="adM">
        </div>
        <div class="adM">
        </div>
        <div class="adM">
        </div>
        <div>
            <div class="adM">
            </div>
            <div class="adM">
            </div>
            <div class="adM">
            </div>
            <h1 style="font-size:14px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0">Chào
                {{ $data['order']->customer_name }}. Đơn hàng của bạn đã đặt thành công!</h1>
            <p
                style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                Chúng tôi đang chuẩn bị hàng để bàn giao cho đơn vị vận chuyển</p>
            <h3
                style="font-size:13px;font-weight:bold;color:#004cffd9;text-transform:uppercase;margin:12px 0 0 0;border-bottom:1px solid #ddd">
                MÃ ĐƠN HÀNG: <b>{{ $data['order']->order_code }}</b> <br>

            </h3>
        </div>
        <div>


            <table
                style="margin:20px 0px;width:100%;border-collapse:collapse;border-spacing:2px;background:#f5f5f5;display:table;box-sizing:border-box;border:0;border-color:grey">
                <thead style="background:red">
                    <tr>
                        <th
                            style="text-align:left;background-color:rgb(13,110,253);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                            <strong>Tên khách hàng</strong>
                        </th>
                        <th
                            style="text-align:left;background-color:rgb(13,110,253);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                            <strong>Email</strong>
                        </th>
                        <th
                            style="text-align:left;background-color:rgb(13,110,253);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                            <strong>SĐT</strong>
                        </th>
                        <th
                            style="text-align:left;background-color:rgb(13,110,253);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                            <strong>Địa chỉ giao hàng</strong>
                        </th>
                        <th
                            style="text-align:left;background-color:rgb(13,110,253);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                            <strong>Trạng thái đơn hàng</strong>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom:1px solid #e1dcdc;font-size:14px;margin-top:10px;line-height:30px">
                        <td style="padding:3px 9px"><strong>{{ $data['order']->customer_name }}</strong></td>
                        <td style="padding:3px 9px"><strong><a href="mailto:nghia101022@gmail.com"
                                    target="_blank">{{ $data['order']->customer_email }}</a></strong></td>
                        <td style="padding:3px 9px"><strong>{{ $data['order']->customer_phone }}</strong></td>
                        <td style="padding:3px 9px"><strong>{{ $data['order']->customer_address }}</strong></td>
                        <td style="padding:3px 9px"><strong><span style="color:#00890099">
                                    @if ((int) $data['order']->order_status === 1)
                                        <span class="badge badge-warning">Đang xử lí</span>
                                    @elseif ((int) $data['order']->order_status === 2)
                                        <span class="badge badge-primary">Đang vận chuyển</span>
                                    @elseif((int) $data['order']->order_status === 3)
                                        <span class="badge badge-success">Vận chuyển thành công</span>
                                    @else
                                        <span class="badge badge-danger">Đơn hàng hủy</span>
                                    @endif
                                </span></strong></td>
                    </tr>
                </tbody>
              
            </table>
            <table
                style="margin:20px 0px;width:100%;border-collapse:collapse;border-spacing:2px;background:#f5f5f5;display:table;box-sizing:border-box;border:0;border-color:grey">
                <thead style="background:rgb(13,110,253)">
                    <tr>
                        <td
                            style="text-align:left;background-color:rgb(13,110,253);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                            <strong>Ảnh</strong>
                        </td>
                        <td
                            style="text-align:left;background-color:rgb(13,110,253);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                            <strong>Tên sản phẩm</strong>
                        </td>
                        <td
                            style="text-align:left;background-color:rgb(13,110,253);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                            <strong>Màu</strong>
                        </td>
                        <td
                            style="text-align:left;background-color:rgb(13,110,253);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                            <strong>Số lượng</strong>
                        </td>
                        <td
                            style="text-align:left;background-color:rgb(13,110,253);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                            <strong>Giá</strong>
                        </td>

                        <td
                            style="text-align:left;background-color:rgb(13,110,253);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                            <strong>Thành tiền</strong>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['products'] as $product)
                        <tr style="border-bottom:1px solid #e1dcdc">
                            <td style="padding:5px">
                                <img style="width: 80px;height:80px;object-fit:contain"
                                    src="{{ $message->embed(asset($product->product_img)) }}" alt="">
                            </td>
                            <td style="padding:3px 9px;vertical-align:middle"><strong>
                                    {{ $product->product_name }}</strong></td>
                            <td style="padding:3px 9px;vertical-align:middle"> {{ $product->product_color }}</td>
                            <td style="padding:3px 9px;vertical-align:middle"> {{ $product->product_qty }}</td>
                            <td style="padding:3px 9px;vertical-align:middle">
                                {{ number_format($product->product_price, 0, '', '.') }}đ</td>
                            <td style="padding:3px 9px;vertical-align:middle">
                                {{ number_format($product->product_price * $product->product_qty, 0, '', '.') }}đ</td>
                        </tr>
                    @endforeach


                </tbody>
            </table>

            <div>
                <p>Quý khách vui lòng giữ lại hóa đơn, hộp sản phẩm và phiếu bảo hành (nếu có) để đổi
                    trả hàng hoặc bảo hành khi cần thiết.</p>
                <p>Liên hệ Hotline <strong style="color:#099202">0123.456.789</strong> (8-21h cả T7,CN).
                </p>
                <p><strong>ISMART MOBILE cảm ơn quý khách đã đặt hàng, chúng tôi sẽ không ngừng nổ lực để phục
                        vụ quý khách tốt hơn!</strong></p>
                <div style="height:auto">
                    <p>
                        Quý khách nhận được email này vì đã dùng email này đặt hàng tại cửa hàng trực
                        tuyến ISMART MOBILE.
                        <br>
                        Nếu không phải quý khách đặt hàng vui lòng liên hệ số điện thoại 0123.456.789
                        hoặc email <a style="color:#4b8da5">2002nnn@gmail.com</a> để hủy đơn hàng
                    </p>
                    <div class="yj6qo"></div>
                    <div class="adL">
                    </div>
                    <div class="adL"></div>
                    <div class="adL">
                    </div>
                    <div class="adL">

                    </div>
                    <div class="adL">
                    </div>
                </div>
                <div class="adL">
                </div>
                <div class="adL">
                </div>
                <div class="adL">
                </div>
            </div>
            <div class="adL">
            </div>
            <div class="adL">
            </div>
            <div class="adL">
            </div>
        </div>
        <div class="adL">
        </div>
        <div class="adL">


        </div>
        <div class="adL">
        </div>
    </div>
    <div class="adL">
    </div>
</div>
