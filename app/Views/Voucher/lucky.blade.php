@extends('layouts.main')
@section('title', 'Lucky Box')
@section('styles')
<style>
    .lucky-body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
        font-family: Arial, sans-serif;
    }

    .lucky-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .lucky-title {
        font-size: 32px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .lucky-spin-counter {
        font-size: 18px;
        color: #333;
        margin-bottom: 10px;
    }

    .lucky-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 20px;
    }

    .lucky-box {
        width: 120px;
        height: 120px;
        background-color: #ffd700;
        border: 5px solid #333;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s;
    }

    .lucky-box:hover:not(.opened) {
        transform: scale(1.05);
    }

    .lucky-box.opened {
        background-color: #fff;
        cursor: default;
    }

    .lucky-box.opened:hover {
        transform: none;
    }

    .lucky-box-content {
        display: none;
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        border-radius: 5px;
    }

    .lucky-box.opened .lucky-box-content {
        display: block;
        animation: fadeIn 0.5s ease-in;
    }

    .lucky-lid {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #d4a017;
        border: 3px solid #333;
        transform-origin: top;
        transition: transform 0.5s ease;
    }

    .lucky-box.opened .lucky-lid {
        transform: rotateX(-180deg);
    }

    .lucky-result {
        margin-top: 20px;
        font-size: 18px;
        font-weight: bold;
        color: #333;
        text-align: center;
    }

    .lucky-voucher-btn {
        display: none;
        margin-top: 10px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        background-color: #333;
        color: white;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        text-align: center;
        transition: background-color 0.3s;
    }

    .lucky-voucher-btn:hover {
        background-color: #555;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.5);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>
@endsection
@section('content')
<div class="lucky-body">
    <div class="lucky-wrapper">
        <div class="lucky-title">Voucher May Mắn</div>
        <div class="lucky-spin-counter" id="spin-counter">Bạn còn 3 lần quay</div>
        <div class="lucky-container">
            @for ($i = 0; $i < 9; $i++)
                <div class="lucky-box" data-index="{{ $i }}" onclick="openBox(this)">
                    <div class="lucky-lid"></div>
                    <img src="{{ APP_URL }}public/images/vouchers/{{ $backgroundImages[$i] }}" 
                         alt="Voucher {{ $i + 1 }}" 
                         class="lucky-box-content" 
                         style="display: none;">
                </div>
            @endfor
        </div>
        <div class="lucky-result" id="result"></div>
        <a class="lucky-voucher-btn" id="voucher-btn" href="#">Nhận Voucher</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const APP_URL = '{{ APP_URL }}';
    
    // Dữ liệu từ controller
    const backgroundImages = <?php echo json_encode($backgroundImages); ?>;
    const userVoucher = '<?php echo $userVoucher; ?>';

    let spinsLeft = 3;
    let isFirstBoxOpened = false;

    function updateSpinCounter() {
        const spinCounter = document.getElementById('spin-counter');
        spinCounter.textContent = `Bạn còn ${spinsLeft} lần quay`;
    }

    function openBox(box) {
        if (spinsLeft <= 0) {
            alert('Bạn đã hết lần quay!');
            return;
        }

        if (isFirstBoxOpened || box.classList.contains('opened')) return;

        isFirstBoxOpened = true;
        spinsLeft--;
        updateSpinCounter();

        const boxIndex = parseInt(box.getAttribute('data-index'));
        
        // Mở ô được chọn và hiển thị voucher người dùng nhận được
        box.classList.add('opened');
        const img = box.querySelector('.lucky-box-content');
        img.src = `${APP_URL}public/images/vouchers/${userVoucher}`;
        img.style.display = 'block';

        // Hiển thị kết quả
        const result = document.getElementById('result');
        result.textContent = `Bạn nhận được Voucher ${userVoucher.replace('.png', '')}`;

        // Cập nhật link nhận voucher
        const voucherBtn = document.getElementById('voucher-btn');
        voucherBtn.href = `${APP_URL}voucher/${userVoucher.replace('.png', '')}`;
        voucherBtn.style.display = 'block';

        // Mở các ô còn lại sau 600ms
        setTimeout(() => {
            const allBoxes = document.querySelectorAll('.lucky-box:not(.opened)');
            allBoxes.forEach((otherBox) => {
                otherBox.classList.add('opened');
                const otherImg = otherBox.querySelector('.lucky-box-content');
                otherImg.style.display = 'block';
            });

            if (spinsLeft <= 0) {
                const allBoxes = document.querySelectorAll('.lucky-box');
                allBoxes.forEach((b) => {
                    b.style.pointerEvents = 'none';
                    b.style.cursor = 'default';
                });
            }
        }, 600);
    }
</script>
@endsection