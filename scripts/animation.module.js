// regebbi projektekbol kiszedett funkciok

/**
 * Fade an element in or out while moving it slightly up/down.
 *
 * @param {HTMLElement} el - element to animate
 * @param {'in'|'out'} mode - "in"  -> fade‑in & slide‑up,
 *                            "out" -> fade‑out & slide‑down
 * @param {Array<number>} bezier - [x1, y1, x2, y2] cubic‑bezier control points
 * @param {number} duration - animation length in ms
 * @param {string?} customEnd - optional arg for specifying a custom end position
 * @returns {Promise} - resolves when the animation finishes
 */
export function fadeSlide(el, mode, bezier, duration, customEnd) {
	if (!(el instanceof HTMLElement)) {
		throw new TypeError("First argument must be an HTMLElement");
	}
	if (!["in", "out"].includes(mode)) {
		throw new TypeError('Mode must be "in" or "out"');
	}
	if (!Array.isArray(bezier) || bezier.length !== 4) {
		throw new TypeError("Bezier must be an array of four numbers");
	}

	const isIn = mode === "in";
	const startOpacity = isIn ? 0 : 1;
	const endOpacity = isIn ? 1 : 0;

	const distance = 20; // how far the element moves
	const startY = isIn ? distance : 0; // start position
	const endY = isIn ? 0 : distance; // end position

	const keyframes = [
		{
			opacity: startOpacity,
			transform: `translateY(${startY}px)`,
		},
		{
			opacity: endOpacity,
			transform: `translateY(${customEnd ? customEnd : `${endY}px`})`,
		},
	];

	const options = {
		duration,
		easing: `cubic-bezier(${bezier.join(",")})`,
		fill: "forwards", // keep final state after animation
	};

	const animation = el.animate(keyframes, options);

	// Return a promise that resolves when the animation finishes
	return animation.finished;
}