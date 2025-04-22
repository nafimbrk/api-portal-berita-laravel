<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'news_content' => $this->news_content,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'author_id' => $this->author_id,
            'author' => $this->whenLoaded('author') // panggil nama fungsi relasi

            // lanjutan penjelasan eager loading
            // padahal anggaplah untuk yang post2 fe gk butuh author, pake egaer loading: $this->whenLoaded('author'), maka post2 gk ngembaliin author sedangkan post tetap ngembaliin author, karena yang di show kita memanggil relationship menggunakan with makanya dia kepanggil juga author nya whenLoaded pake eager loading sedangkan show2 kita gk manggil relationship kita gk make method with jadi hasilnya kita juga gk manggil relationship author nya
        ];
    }
}
