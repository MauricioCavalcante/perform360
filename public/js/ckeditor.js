import {
    ClassicEditor,
    Essentials,
    Bold,
    Italic,
    Font,
    Paragraph,
    Alignment,
    List,
    Strikethrough, Subscript, Superscript, Underline
} from 'ckeditor5';

const initializeEditor = async (element) => {
    try {
        const editor = await ClassicEditor.create(element, {
            plugins: [ 
                Essentials, Bold, Italic, Font, Paragraph, Alignment, List,
                Strikethrough, Subscript, Superscript, Underline
            ],
            fontSize: {
                options: [
                    9, 11, 13,
                    'default', 17, 19, 21, 30, 35
                ]
            },
            toolbar: {
                items: [
                    'undo', 'redo', '|', 'bold', 'italic', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor','|',
                    'alignment', '|',
                    'numberedList', 'bulletedList','|',
                    'underline', 'strikethrough', 'subscript', 'superscript'
                ]
            }
        });
        console.log('Editor was initialized.', editor);
    } catch (error) {
        console.error('There was a problem initializing the editor.', error);
    }
};

document.querySelectorAll('.ckeditor').forEach(element => {
    initializeEditor(element);
});