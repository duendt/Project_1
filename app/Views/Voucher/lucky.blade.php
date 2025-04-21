<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lucky Box</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            font-family: Arial, sans-serif;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .title {
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .spin-counter {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }

        .container {
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

        .box-content {
            display: none;
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            border-radius: 5px;
        }

        .lucky-box.opened .box-content {
            display: block;
            animation: fadeIn 0.5s ease-in;
        }

        .lid {
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

        .lucky-box.opened .lid {
            transform: rotateX(-180deg);
        }

        #result {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            text-align: center;
        }

        #voucher-btn {
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

        #voucher-btn:hover {
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
</head>

<body>
    <div class="wrapper">
        <div class="title">Voucher May Mắn</div>
        <div class="spin-counter" id="spin-counter">Bạn còn 3 lần quay</div>
        <div class="container">
            <div class="lucky-box" data-index="1" onclick="openBox(this)">
                <div class="lid"></div>
            </div>
            <div class="lucky-box" data-index="2" onclick="openBox(this)">
                <div class="lid"></div>
            </div>
            <div class="lucky-box" data-index="3" onclick="openBox(this)">
                <div class="lid"></div>
            </div>
            <div class="lucky-box" data-index="4" onclick="openBox(this)">
                <div class="lid"></div>
            </div>
            <div class="lucky-box" data-index="5" onclick="openBox(this)">
                <div class="lid"></div>
            </div>
            <div class="lucky-box" data-index="6" onclick="openBox(this)">
                <div class="lid"></div>
            </div>
            <div class="lucky-box" data-index="7" onclick="openBox(this)">
                <div class="lid"></div>
            </div>
            <div class="lucky-box" data-index="8" onclick="openBox(this)">
                <div class="lid"></div>
            </div>
            <div class="lucky-box" data-index="9" onclick="openBox(this)">
                <div class="lid"></div>
            </div>
        </div>
        <div id="result"></div>
        <a id="voucher-btn" href="#">Nhận Voucher</a>
    </div>
    <?php 
    $app_url = APP_URL;
    ?>
    <script>
        const APP_URL = '<?php echo $app_url; ?>'; // Giả lập hằng số APP_URL, thay bằng giá trị thực tế

        // 8 item cố định
        const fixedItems = [
            { name: 'Gift1', image: `${APP_URL}public/images/vouchers/1TR.png` },
            { name: 'Gift2', image: `${APP_URL}public/images/vouchers/1TR.png` },
            { name: 'Gift3', image: `${APP_URL}public/images/vouchers/1TR.png` },
            { name: 'Gift4', image: `${APP_URL}public/images/vouchers/1TR.png` },
            { name: 'Gift5', image: `${APP_URL}public/images/vouchers/1TR.png` },
            { name: 'Gift6', image: `${APP_URL}public/images/vouchers/1TR.png` },
            { name: 'Gift7', image: `${APP_URL}public/images/vouchers/1TR.png` },
            { name: 'Gift8', image: `${APP_URL}public/images/vouchers/1TR.png` }
        ];

        // Tạo item random
        const randomItem = {
            name: 'SpecialGift',
            image: `${APP_URL}public/images/vouchers/100K.png`
        };

        // Mảng items: randomItem ở vị trí 0, sau đó là 8 fixedItems
        let items = [randomItem, ...fixedItems];

        let spinsLeft = 3; // Số lần quay còn lại
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

            const boxIndex = parseInt(box.getAttribute('data-index')); // Ô được chọn (1-9)
            const arrayIndex = boxIndex - 1; // Chỉ số trong mảng items (0-8)

            // Hoán đổi item tại vị trí 0 với item tại vị trí được chọn
            [items[0], items[arrayIndex]] = [items[arrayIndex], items[0]];

            // Mở ô được chọn
            box.classList.add('opened');
            const img = document.createElement('img');
            img.classList.add('box-content');
            img.src = items[arrayIndex].image; // Hình ảnh của ô được chọn (sau khi hoán đổi)
            box.appendChild(img);

            // Hiển thị text "Bạn nhận được - số ô"
            const result = document.getElementById('result');
            result.textContent = `Bạn nhận được - Ô ${randomItem.name}`;

            // Tạo href cho button
            const voucherBtn = document.getElementById('voucher-btn');
            voucherBtn.href = `${APP_URL}voucher/${items[arrayIndex].name}`;
            voucherBtn.style.display = 'block';

            // Mở tất cả các ô còn lại sau 600ms
            setTimeout(() => {
                const allBoxes = document.querySelectorAll('.lucky-box:not(.opened)');
                allBoxes.forEach((otherBox) => {
                    otherBox.classList.add('opened');
                    const otherIndex = parseInt(otherBox.getAttribute('data-index')) - 1;
                    const otherImg = document.createElement('img');
                    otherImg.classList.add('box-content');
                    otherImg.src = items[otherIndex].image;
                    otherBox.appendChild(otherImg);
                });

                // Nếu hết lần quay, vô hiệu hóa các box
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
</body>

</html>