export default function formatDate(isoString) {
	const dateObj = new Date(isoString);
	
	const formatted = new Intl.DateTimeFormat('id-ID', {
	  dateStyle: 'full', // Contoh: Selasa, 18 Februari 2025
	  timeStyle: 'medium' // Contoh: 21.30.00
	}).format(dateObj);
	
	return formatted;
}
