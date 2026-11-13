<?php
namespace App\Http\Controllers;
use App\Models\Lesson;
use App\Models\LessonMedia;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
class LessonMediaController extends Controller {
 private function editor(Request $request): void {
  abort_unless($request->user()?->is_active && $request->user()?->is_content_editor,403);
 }
 public function store(Request $request,Lesson $lesson): RedirectResponse {
  $this->editor($request);
  $data=$request->validate([
   'kind'=>'required|in:image,video_link',
   'title'=>'required|string|max:150',
   'alt_text'=>'required_if:kind,image|nullable|string|max:1000',
   'transcript'=>'required_if:kind,video_link|nullable|string|max:20000',
   'language'=>'required|string|max:20',
   'sort_order'=>'nullable|integer|min:0|max:100000',
   'image'=>'required_if:kind,image|nullable|image|mimes:jpeg,png,webp|max:4096',
   'external_url'=>'required_if:kind,video_link|nullable|url|starts_with:https://|max:2048',
  ]);
  $path=null;
  if($data['kind']==='image') {
   $path=$request->file('image')->store('lesson-media','local');
  }
  $lesson->media()->create([
   'kind'=>$data['kind'],'title'=>$data['title'],'path'=>$path,
   'external_url'=>$data['kind']==='video_link'?$data['external_url']:null,
   'alt_text'=>$data['kind']==='image'?$data['alt_text']:null,
   'transcript'=>$data['kind']==='video_link'?$data['transcript']:null,
   'language'=>$data['language'],'sort_order'=>$data['sort_order']??0,
  ]);
  return back()->with('status','Accessible media added.');
 }
 public function show(Request $request,LessonMedia $media): BinaryFileResponse {
  $lesson=$media->lesson;
  abort_unless($lesson->is_published || ($request->user()?->is_active && $request->user()?->is_content_editor),404);
  abort_unless($media->kind==='image' && $media->path && Storage::disk('local')->exists($media->path),404);
  return response()->file(Storage::disk('local')->path($media->path),[
   'Content-Type'=>match(strtolower(pathinfo($media->path,PATHINFO_EXTENSION))){'jpg','jpeg'=>'image/jpeg','png'=>'image/png','webp'=>'image/webp',default=>'application/octet-stream'},
   'X-Content-Type-Options'=>'nosniff','Cache-Control'=>'private, max-age=300',
  ]);
 }
 public function destroy(Request $request,LessonMedia $media): RedirectResponse {
  $this->editor($request);
  $request->validate(['confirmation'=>'required|in:DELETE']);
  $path=$media->path;
  $media->delete();
  if($path) Storage::disk('local')->delete($path);
  return back()->with('status','Media removed.');
 }
}
