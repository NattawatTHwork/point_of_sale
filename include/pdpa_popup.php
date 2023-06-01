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

<div id="cookieNotice" class="pdpa-popup">
    <p>เว็บไซต์นี้ใช้คุกกี้เพื่อให้คุณได้รับประสบการณ์ที่ดีที่สุด โดยเราใช้คุกกี้และนโยบายความเป็นส่วนตัวของเรา โปรดดูข้อมูลเพิ่มเติมใน เว็บไซต์นี้ใช้คุกกี้เพื่อให้คุณได้รับประสบการณ์ที่ดีที่สุด โดยเราใช้คุกกี้และนโยบายความเป็นส่วนตัวของเรา โปรดดูข้อมูลเพิ่มเติมใน<a href="privacy_policy.php">นโยบายความเป็นส่วนตัว</a>ของเรา</p>
    <button type="button" onclick="acceptCookieConsent()">ยอมรับ</button>
</div>

<script>
    // Create cookie
    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    // Delete cookie
    function deleteCookie(cname) {
        const d = new Date();
        d.setTime(d.getTime() + (24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=;" + expires + ";path=/";
    }

    // Read cookie
    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function closepopup() {
        document.getElementById("cookieNotice").style.display = "none";
    }

    // Set cookie consent
    function acceptCookieConsent() {
        deleteCookie('user_cookie_consent');
        setCookie('user_cookie_consent', 1, 30);
        document.getElementById("cookieNotice").style.display = "none";
    }

    let cookie_consent = getCookie("user_cookie_consent");
    if (cookie_consent != "") {
        document.getElementById("cookieNotice").style.display = "none";
    } else {
        document.getElementById("cookieNotice").style.display = "block";
    }
</script>