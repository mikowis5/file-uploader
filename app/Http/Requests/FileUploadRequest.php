<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

/**
 * @property string $email
 * @property string $username
 */
class FileUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,webp,tiff,bmp',
                'max:5120',
                Rule::dimensions()->minWidth(500)->minHeight(500),
            ],
            'email' => 'required|email',
            'username' => 'required|max:255',
        ];
    }

    public function hasFiles(): bool
    {
        return $this->hasFile('file');
    }

    /**
     * @return UploadedFile[]
     */
    public function getFiles(): array
    {
        return Arr::wrap($this->file('file'));
    }
}
