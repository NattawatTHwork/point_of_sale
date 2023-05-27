<style>
    .pdpa-popup {
        position: fixed;
        bottom: 20px;
        left: 20px;
        background: #f1f1f1;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.3);
        font-family: Arial, sans-serif;
        font-size: 14px;
        z-index: 9999;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .pdpa-popup p {
        margin: 0;
    }

    .pdpa-popup button {
        margin-top: 10px;
        background-color: #4e73df;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .pdpa-popup button:hover {
        background-color: #375ab3;
    }
</style>

<div class="pdpa-popup">
    <p>เว็บไซต์นี้ใช้คุกกี้เพื่อให้คุณได้รับประสบการณ์ที่ดีที่สุด โดยเราใช้คุกกี้และนโยบายความเป็นส่วนตัวของเรา โปรดดูข้อมูลเพิ่มเติมใน<a href="privacy_policy.php" style="color: #4e73df; text-decoration: none;">นโยบายความเป็นส่วนตัว</a></p>
    <button onclick="acceptPDPA()">ยอมรับ</button>
</div>

<script>
    function acceptPDPA() {
        // Set the 'pdpa_accepted' cookie with a value of 'true' that expires in 30 days
        document.cookie = "pdpa_accepted=true; expires=" + new Date(new Date().getTime() + (86400 * 30 * 1000)).toUTCString();

        // Hide the privacy policy popup
        document.querySelector('.pdpa-popup').style.display = 'none';
    }

    // Check if the consent has been accepted from the cookie
    function checkPDPAConsent() {
        var cookies = document.cookie.split(';');
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i].trim();
            if (cookie.indexOf('pdpa_accepted=') === 0) {
                return true;
            }
        }
        return false;
    }

    // Show the privacy policy popup only if consent has not been accepted
    if (!checkPDPAConsent()) {
        var pdpaPopup = document.createElement('div');
        pdpaPopup.className = 'pdpa-popup';
        pdpaPopup.innerHTML = '<p>เว็บไซต์นี้ใช้คุกกี้เพื่อให้คุณได้รับประสบการณ์ที่ดีที่สุด โดยเราใช้คุกกี้และนโยบายความเป็นส่วนตัวของเรา โปรดดูข้อมูลเพิ่มเติมใน<a href="privacy_policy.php" style="color: #4e73df; text-decoration: none;">นโยบายความเป็นส่วนตัว</a></p><button onclick="acceptPDPA()" style="background-color: #4e73df;">ยอมรับ</button>';
        document.body.appendChild(pdpaPopup);
    }
</script>