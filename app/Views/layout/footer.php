<style>
        /* Estilos */
        .footer-mycar {
            background-color: #0f172a; 
            color: #94a3b8; 
            padding: 30px 20px;
            margin-top: auto; 
            border-top: 1px solid #1e293b;
        }

        .footer-mycar strong {
            color: #ffffff;
        }

        .footer-authors {
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .footer-authors i {
            color: #059669; /* Icono verde */
        }

        .footer-copyright {
            font-size: 0.85rem;
            color: #64748b;
            margin-top: 6px;
        }
    </style>

    <footer class="footer footer-mycar">
        <div class="content has-text-centered">
            <p class="footer-authors">
                <i class="fa-solid fa-code"></i>
                Desarrollado por: <strong>Facundo Homola</strong> & <strong>Octavio Riccardo</strong>
            </p>
            <p class="footer-copyright">
                &copy; <?= date('Y'); ?> MyCar App. Todos los derechos reservados.
            </p>
        </div>
    </footer>

</body>
</html>