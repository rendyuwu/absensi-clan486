// Sidenav
const sideNav = document.querySelectorAll('.sidenav');
M.Sidenav.init(sideNav);

// Slider
const slider = document.querySelectorAll('.slider');
M.Slider.init(slider, {
	indicators: false,
	height: 500,
	transition: 600,
	interval: 4000
});

// Parallax
const parallax = document.querySelectorAll('.parallax');
M.Parallax.init(parallax);

// Portfolio
const materialbox = document.querySelectorAll('.materialboxed');
M.Materialbox.init(materialbox);

// Scrollspy
const scrollspy = document.querySelectorAll('.scrollspy');
M.ScrollSpy.init(scrollspy, {
	scrollOffset: 50
});
