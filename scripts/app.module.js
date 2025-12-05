import { fadeSlide } from "/scripts/animation.module";

const form = document.getElementById("loginForm");
const modal = document.getElementById("msgModal");
const modalBody = document.getElementById("modalBody");

async function showModal(text) {
	modalBody.innerHTML = text;
	modal.style.display = "flex";
    await fadeSlide(modalBody, "in", [0.27, 1.06, 0.18, 1.0], 350);
}

modal.addEventListener("click", async () => {
    await fadeSlide(modalBody, "out", [0.27, 1.06, 0.18, 1.0], 350);
	modal.style.display = "none";
});

form.addEventListener("submit", async (e) => {
	e.preventDefault();

	const formData = new FormData(form);
	const resp = await fetch("", {
		method: "POST",
		body: formData,
	});

	const data = await resp.json();
	showModal(data.message, data.success ? data.color : null);
});
