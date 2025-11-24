import './bootstrap';
// small UI helpers
window.addEventListener('DOMContentLoaded', function () {
	const btn = document.getElementById('sidebarToggle');
	const sidebar = document.getElementById('appSidebar');
	if (btn && sidebar) {
		btn.addEventListener('click', () => {
			sidebar.classList.toggle('hidden');
		});
	}
});
