<style>
    .skeleton-loader {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 20px;
    }

    .loader-header,
    .loader-body {
        display: flex;
        flex-direction: column;
    }

    .skeleton {
        background-color: #ddd;
        border-radius: 4px;
    }

    .skeleton-text {
        width: 70%;
        height: 20px;
        margin-bottom: 10px;
    }

    .skeleton-close {
        width: 10px;
        height: 10px;
        align-self: flex-end;
    }

    .skeleton-input {
        width: 100%;
        height: 20px;
    }

    .skeleton-textarea {
        width: 100%;
        height: 60px;
    }

    /* Animation to show loading effect */
    .skeleton {
        animation: shimmer 1.5s infinite linear;
    }

    @keyframes shimmer {
        0% {
            background-color: #e0e0e0;
        }

        50% {
            background-color: #c7c7c7;
        }

        100% {
            background-color: #e0e0e0;
        }
    }

    .file-icon>p {
        font-size: medium;
    }

    /* table > tbody > tr > td {
        text-align: center !important;
    } */
    table>thead>tr>th {
        text-align: right !important;
    }

    .modal-xl {
        max-width: 90%;
        /* You can adjust this percentage as needed */
    }

    .wideget-user-desc .wideget-user-img img {
        box-shadow: none;

    }

    .avatar {
        background: none;
    }
</style>

<style>
    /* Dropzone Styling */
    .dropzone-style {
        border: 2px dashed #d3d3d3;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.3s;
        position: relative;
        min-height: 150px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .dropzone-style.dz-drag-hover {
        border-color: #00F3CA;
        background-color: rgba(0, 243, 202, 0.05);
    }

    .dz-message {
        color: #666;
        margin-bottom: 20px;
    }

    .dz-message i {
        font-size: 48px;
        color: #bbb;
        margin-bottom: 15px;
        display: block;
    }

    .dz-message h3 {
        font-size: 18px;
        margin-bottom: 5px;
        color: #333;
    }

    .dz-submessage {
        font-size: 14px;
        color: #999;
    }

    .dz-hidden-input {
        display: none;
    }

    /* Previews Container */
    .dropzone-previews {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 20px;
    }

    /* File Preview Items */
    .file-preview {
        position: relative;
        width: 120px;
        background: white;
        border-radius: 8px;
        padding: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .file-preview-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 8px;
    }

    .file-preview-icon {
        font-size: 40px;
        color: #666;
        margin-bottom: 8px;
    }

    .file-preview-name {
        font-size: 12px;
        text-align: center;
        word-break: break-all;
        max-height: 36px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .file-preview-size {
        font-size: 10px;
        color: #999;
        margin-top: 4px;
    }

    .file-preview-remove {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        background: #ff4444;
        color: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
        padding: 0;
        z-index: 10;
    }

    .file-preview-remove:hover {
        background: #cc0000;
    }

    /* Progress Bar */
    .file-preview-progress {
        width: 100%;
        height: 4px;
        background: #e9ecef;
        border-radius: 2px;
        margin-top: 8px;
        overflow: hidden;
    }

    .file-preview-progress-bar {
        height: 100%;
        background: #00F3CA;
        width: 0%;
        transition: width 0.3s;
    }
</style>
