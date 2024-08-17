<style>
    /*Loader*/
        #preloader{
            position: fixed;
            background: white;
            z-index: 100;
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .spinner {
            width: 56px;
            height: 56px;
            display: grid;
            border: 4.5px solid #0000;
            border-radius: 50%;
            border-right-color: #474bff;
            animation: spinner-a4dj62 1s infinite linear;
        }

        .spinner::before,
        .spinner::after {
            content: "";
            grid-area: 1/1;
            margin: 2.2px;
            border: inherit;
            border-radius: 50%;
            animation: spinner-a4dj62 2s infinite;
        }

        .spinner::after {
            margin: 8.9px;
            animation-duration: 3s;
        }

        @keyframes spinner-a4dj62 {
            100% {
                transform: rotate(1turn);
            }
        }
    /*end*/
</style>

    <div id="preloader">
        <div class="spinner"></div>
    </div>

<script>
    //Preloader
        var loader = document.getElementById('preloader');
        window.addEventListener("load",function(){
            loader.style.display = "none";
        });
    //end
</script>