<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Http\Request;



class AvatarController extends Controller
{
    public function update(UpdateAvatarRequest $request)
    {
        $path = Storage::disk('public')->put('avatars', $request->file('avatar'));
        // $path = $request->file('avatar')->store('avatars', 'public');

        if($oldAvatar = $request->user()->avatar){
            Storage::disk('public')->delete($oldAvatar);
        }
        auth()->user()->update(['avatar' => $path]);
        dd(auth()->user());

        return redirect(route('profile.edit'))->with('message','Avatar has been updated');
    }

    public function generate(Request $request)
    {
        $result = OpenAI::images()->create([
            'prompt' => 'create a cool, animated, techno avatar',
            'n' => 1,
            'size' => "256x256"
        ]);

        $contents = file_get_contents($result->data[0]->url);

        $filename = Str::random(25);

        if($oldAvatar = $request->user()->avatar){
            Storage::disk('public')->delete($oldAvatar);
        }

        Storage::disk('public')->put("avatars/$filename.jpg", $contents);
    }
}


