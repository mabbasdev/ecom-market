<!-- 
Usage example
$_SESSION['toast-message'] = "Welcome Back!";
$_SESSION['toast-icon'] = "success";
header("Location: index.php");
exit(); -->


<?php

// Ensure session is started if not already done in the parent script
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (function_exists('cart')) {
    cart();
}
if (isset($_SESSION['toast-message'])) {
    // json_encode safely handles string quoting and prevents JS injection breaks
    $toastMessage = json_encode($_SESSION['toast-message']);
    $toastIcon = json_encode($_SESSION['toast-icon'] ?? "info");

    unset($_SESSION['toast-message']);
    unset($_SESSION['toast-icon']);

    // Output wrapped inside an executable script block
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            toast.show($toastMessage, $toastIcon);
        });
    </script>";
}
?>
<div id="toast-container"></div>
<style>
    /* Toast Container */
    #toast-container {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 12px;
        pointer-events: none;
    }

    /* Toast */
    .toast {
        min-width: 320px;
        max-width: 420px;
        padding: 16px 18px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        backdrop-filter: blur(12px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
        color: white;
        font-family: system-ui, sans-serif;
        transform: translateX(120%);
        opacity: 0;
        pointer-events: auto;
        animation: slideIn 0.45s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        position: relative;
        overflow: hidden;
    }

    /* Progress bar */
    .toast::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        width: 100%;
        background: rgba(255, 255, 255, 0.35);
        animation: progress linear forwards;
        animation-duration: inherit;
    }

    /* Types */
    .toast.success {
        background: linear-gradient(135deg, #16a34a, #22c55e);
    }

    .toast.error {
        background: linear-gradient(135deg, #dc2626, #ef4444);
    }

    .toast.warning {
        background: linear-gradient(135deg, #d97706, #f59e0b);
    }

    .toast.info {
        background: linear-gradient(135deg, #2563eb, #3b82f6);
    }

    .toast-content {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .toast-icon {
        font-size: 20px;
    }

    .toast-message {
        font-size: 15px;
        font-weight: 500;
    }

    .toast-close {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 18px;
        opacity: 0.8;
        transition: opacity 0.2s ease;
    }

    .toast-close:hover {
        opacity: 1;
    }

    /* Exit */
    .toast.hide {
        animation: slideOut 0.35s ease forwards;
    }

    @keyframes slideIn {
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        to {
            transform: translateX(120%);
            opacity: 0;
        }
    }

    @keyframes progress {
        from {
            width: 100%;
        }

        to {
            width: 0%;
        }
    }

    /* Mobile */
    @media (max-width: 600px) {
        #toast-container {
            top: 16px;
            right: 16px;
            left: 16px;
        }

        .toast {
            min-width: auto;
            width: 100%;
        }
    }
</style>
<script>
    const toast = (() => {
        const icons = {
            success: "✓",
            error: "✕",
            warning: "⚠",
            info: "ℹ"
        };

        function show(message, type = "info", duration = 4000) {
            const container = document.getElementById("toast-container");
            if (!container) return;

            const toastEl = document.createElement("div");
            toastEl.className = `toast ${type}`;

            toastEl.innerHTML = `
              <div class="toast-content">
                <span class="toast-icon">${icons[type] || 'ℹ'}</span>
                <span class="toast-message">${message}</span>
              </div>
              <button class="toast-close">&times;</button>
            `;

            toastEl.style.setProperty("animation-duration", `0.45s, ${duration}ms`);

            toastEl.querySelector(".toast-close").addEventListener("click", () => {
                removeToast(toastEl);
            });

            container.appendChild(toastEl);

            const autoCloseTimeout = setTimeout(() => {
                removeToast(toastEl);
            }, duration);

            toastEl.dataset.timeoutId = autoCloseTimeout;
        }

        function removeToast(toastEl) {
            if (!toastEl || toastEl.classList.contains("hide")) return;
            clearTimeout(toastEl.dataset.timeoutId);

            toastEl.classList.add("hide");
            toastEl.addEventListener("animationend", () => {
                toastEl.remove();
            }, {
                once: true
            });
        }

        return {
            show
        };
    })();
</script>