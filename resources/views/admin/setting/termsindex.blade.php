@extends('admin/layouts/master')

@section('title')
    {{ config()->get('app.name') }} | {{ $bladeName }}
@endsection
@section('page_name')
    {{ $bladeName }}
@endsection
@section('content')
    <div>
        <div class="card-body">
            <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{ route('settings.update') }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <input type="hidden" name="key" value="terms">


                    <div class="col-md-12">
                        <label class="labels">{{ trns('terms_in_arabic') }}</label>
                        <textarea class="form-control editor_ar" name="terms[ar]" rows="10">
                            {{ json_decode($settings->where('key', 'terms')->first()->value, true)['ar'] }}
                        </textarea>
                    </div>

                    <div class="col-md-12 mt-5">
                        <label class="labels">{{ trns('terms_in_english') }}</label>
                        <textarea class="form-control editor_en" name="terms[en]" rows="10">
                            {{ json_decode($settings->where('key', 'terms')->first()->value, true)['en'] }}
                        </textarea>
                    </div>
                </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="mt-5 text-right mr-5">
                <button type="submit" class="btn btn-primary" id="updateButton">{{ trns('update') }}</button>
            </div>
        </div>
    </div>
    </form>
    <!-- End Form -->
    @include('admin.layouts.myAjaxHelper')

@endsection
@section('ajaxCalls')
    <script>
        editScript();
    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.editor_ar').forEach((textarea) => {
                ClassicEditor
                    .create(textarea, {
                        // اللغة (دعم العربية)
                        language: 'ar',

                        // شريط الأدوات المخصص
                        toolbar: {
                            items: [
                                'heading', '|',
                                'bold', 'italic', 'underline', 'strikethrough', '|',
                                'alignment', '|',
                                'numberedList', 'bulletedList', '|',
                                'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                                'link', 'imageUpload', 'mediaEmbed', '|',
                                'undo', 'redo', '|',
                                'code', 'codeBlock', '|',
                                'horizontalLine', 'pageBreak', '|',
                                'sourceEditing'
                            ],
                            shouldNotGroupWhenFull: true
                        },

                        // حجم المحرر
                        height: '500px',

                        // الخطوط المتاحة
                        fontFamily: {
                            options: [
                                'default',
                                'Arial, Helvetica, sans-serif',
                                'Courier New, Courier, monospace',
                                'Georgia, serif',
                                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                                'Tahoma, Geneva, sans-serif',
                                'Times New Roman, Times, serif',
                                'Trebuchet MS, Helvetica, sans-serif',
                                'Verdana, Geneva, sans-serif',
                                'Traditional Arabic, Arabic Typesetting'
                            ]
                        },

                        // أحجام الخطوط
                        fontSize: {
                            options: [10, 12, 14, 'default', 18, 20, 22, 24, 28, 32, 36],
                            supportAllValues: true
                        },

                        // رفع الصور
                        simpleUpload: {
                            uploadUrl: '/upload-image', // يجب إنشاء هذا الراوت في الباك اند
                            withCredentials: true,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        },

                        // المحاذاة
                        alignment: {
                            options: ['left', 'center', 'right', 'justify']
                        },

                        // إعدادات إضافية
                        heading: {
                            options: [
                                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                            ]
                        },

                        // تمكين HTML source
                        htmlSupport: {
                            allow: [
                                {
                                    name: /.*/,
                                    attributes: true,
                                    classes: true,
                                    styles: true
                                }
                            ]
                        }
                    })
                    .then(editor => {
                        editor.ui.view.editable.element.style.minHeight = '300px';

                        // يمكنك الوصول إلى الإنستنس هنا
                        console.log('Editor initialized', editor);

                        // مثال: حدث عند تغيير المحتوى
                        editor.model.document.on('change:data', () => {
                            console.log('Content changed!', editor.getData());
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });

            document.querySelectorAll('.editor_en').forEach((textarea) => {
                ClassicEditor
                    .create(textarea, {
                        // اللغة (دعم العربية)
                        language: 'en',

                        // شريط الأدوات المخصص
                        toolbar: {
                            items: [
                                'heading', '|',
                                'bold', 'italic', 'underline', 'strikethrough', '|',
                                'alignment', '|',
                                'numberedList', 'bulletedList', '|',
                                'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                                'link', 'imageUpload', 'mediaEmbed', '|',
                                'undo', 'redo', '|',
                                'code', 'codeBlock', '|',
                                'horizontalLine', 'pageBreak', '|',
                                'sourceEditing'
                            ],
                            shouldNotGroupWhenFull: true
                        },

                        // حجم المحرر
                        height: '500px',

                        // الخطوط المتاحة
                        fontFamily: {
                            options: [
                                'default',
                                'Arial, Helvetica, sans-serif',
                                'Courier New, Courier, monospace',
                                'Georgia, serif',
                                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                                'Tahoma, Geneva, sans-serif',
                                'Times New Roman, Times, serif',
                                'Trebuchet MS, Helvetica, sans-serif',
                                'Verdana, Geneva, sans-serif',
                                'Traditional Arabic, Arabic Typesetting'
                            ]
                        },

                        // أحجام الخطوط
                        fontSize: {
                            options: [10, 12, 14, 'default', 18, 20, 22, 24, 28, 32, 36],
                            supportAllValues: true
                        },

                        // رفع الصور
                        simpleUpload: {
                            uploadUrl: '/upload-image', // يجب إنشاء هذا الراوت في الباك اند
                            withCredentials: true,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        },

                        // المحاذاة
                        alignment: {
                            options: ['left', 'center', 'right', 'justify']
                        },

                        // إعدادات إضافية
                        heading: {
                            options: [
                                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                            ]
                        },

                        // تمكين HTML source
                        htmlSupport: {
                            allow: [
                                {
                                    name: /.*/,
                                    attributes: true,
                                    classes: true,
                                    styles: true
                                }
                            ]
                        }
                    })
                    .then(editor => {
                        editor.ui.view.editable.element.style.minHeight = '300px';

                        // يمكنك الوصول إلى الإنستنس هنا
                        console.log('Editor initialized', editor);

                        // مثال: حدث عند تغيير المحتوى
                        editor.model.document.on('change:data', () => {
                            console.log('Content changed!', editor.getData());
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    </script>
@endsection
