<!-- Footer -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-section">
            <h3>О компании</h3>
            <p>Автосалон с большим выбором качественных автомобилей по доступным ценам.</p>
        </div>
        
        <div class="footer-section">
            <h3>Быстрые ссылки</h3>
            <ul>
                <li><a href="home.php">Каталог</a></li>
                <li><a href="home.php">О нас</a></li>
                <li><a href="home.php">Контакты</a></li>
            </ul>
        </div>
        
        <div class="footer-section">
            <h3>Контакты</h3>
            <p>
                Телефон: +7 (999) 123-45-67<br>
                Email: info@autopark.ru<br>
                Адрес: г. Караганда, пр. Бухар-Жырау, 123
            </p>
        </div>
        
        <div class="footer-section">
            <h3>Социальные сети</h3>
            <div class="social-links">
                <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
                <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" title="VK"><i class="fab fa-vk"></i></a>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; 2024-2026 Автосалон. Все права защищены.</p>
    </div>
</footer>

<style>
    /* Footer Styles */
    footer.footer {
        background: #2c2c2c;
        color: #fff;
        margin-top: 60px;
        padding: 48px 0 20px;
        border-top: 1px solid #1a1a1a;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
        margin-bottom: 30px;
    }

    .footer-section h3 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 16px;
        letter-spacing: -0.3px;
    }

    .footer-section p {
        font-size: 14px;
        line-height: 1.6;
        color: #ccc;
        font-weight: 400;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-section ul li {
        margin-bottom: 10px;
    }

    .footer-section ul li a {
        color: #ccc;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.2s ease;
        font-weight: 400;
    }

    .footer-section ul li a:hover {
        color: #fff;
    }

    .social-links {
        display: flex;
        gap: 16px;
    }

    .social-links a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
        color: #fff;
        font-size: 16px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .social-links a:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .footer-bottom {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        color: #999;
        font-size: 13px;
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .footer-container {
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }

        footer.footer {
            margin-top: 40px;
            padding: 32px 0 16px;
        }
    }

    @media (max-width: 480px) {
        .footer-container {
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .footer-section h3 {
            font-size: 14px;
            margin-bottom: 12px;
        }

        .footer-section p {
            font-size: 13px;
        }

        .footer-section ul li a {
            font-size: 13px;
        }

        footer.footer {
            margin-top: 30px;
            padding: 24px 0 12px;
        }
    }
</style>
