<footer>
    <p>&copy; 2025 Karpol</p>
</footer>

<style>
    /* Flexbox dla całej strony */
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }

    .container {
        flex-grow: 1; /* Kontener rośnie, by wypełnić dostępną przestrzeń */
    }

    footer {
        background-color: #333;
        color: white;
        padding: 10px;
        text-align: center;
        width: 100%;
        box-sizing: border-box; /* Zlicza padding do szerokości */
        position: relative;
    }
</style>
