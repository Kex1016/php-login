const form = document.getElementById("loginForm");
const modal = document.getElementById("msgModal");
const modalBody = document.getElementById("modalBody");

function showModal(text, bgColor = null) {
	modalBody.innerHTML = text;
	if (bgColor) {
		modalBody.style.backgroundColor = bgColor;
		modalBody.style.color = "#000000ff";
	} else {
		modalBody.style.backgroundColor = "";
		modalBody.style.color = "";
	}
	modal.style.display = "flex";
}

modal.addEventListener("click", () => {
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
