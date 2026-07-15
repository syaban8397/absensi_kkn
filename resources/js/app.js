import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

function kknShellState() {
    return {
        sidebarOpen: false,
        timeOpen: false,
        now: new Date(),

        get dateLine() {
            return this.now.toLocaleDateString('id-ID', {
                weekday: 'short',
                day: '2-digit',
                month: 'short',
                year: 'numeric',
            });
        },

        get clockLine() {
            return this.now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
            });
        },

        get fullDate() {
            return this.now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: '2-digit',
                month: 'long',
                year: 'numeric',
            });
        },

        get clockWithSeconds() {
            return this.now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
            });
        },

        get dayNumber() {
            return this.now.toLocaleDateString('id-ID', { day: '2-digit' });
        },

        get monthLine() {
            return this.now.toLocaleDateString('id-ID', { month: 'long' });
        },

        get yearLine() {
            return this.now.toLocaleDateString('id-ID', { year: 'numeric' });
        },

        init() {
            this.now = new Date();
            window.setInterval(() => {
                this.now = new Date();
            }, 1000);
        },
    };
}

window.kknShell = window.kknShell || kknShellState;

Alpine.data('kknShell', kknShellState);

Alpine.start();
