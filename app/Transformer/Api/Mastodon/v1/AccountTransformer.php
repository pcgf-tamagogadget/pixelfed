<?php

namespace App\Transformer\Api\Mastodon\v1;

use App\Profile;
use League\Fractal;

class AccountTransformer extends Fractal\TransformerAbstract
{
	public function transform(Profile $profile)
	{
		$local = $profile->domain == null;
		$is_admin = !$local ? false : $profile->user->is_admin;
		$acct = $local ? $profile->username . '@' . config('pixelfed.domain.app') : substr($profile->username, 1);
		$username = $local ? $profile->username : explode('@', $acct)[0];
		return [
			'id' => (string) $profile->id,
			'username' => $username,
			'acct' => $acct,
			'display_name' => $profile->name,
			'locked' => (bool) $profile->is_private,
			'created_at' => $profile->created_at->toJSON(),
			'followers_count' => $profile->followerCount(),
			'following_count' => $profile->followingCount(),
			'statuses_count' => (int) $profile->statusCount(),
			'note' => $profile->bio ?? '',
			'url' => $profile->url(),
			'avatar' => $profile->avatarUrl(),
			'avatar_static' => $profile->avatarUrl(),
			'header' => '',
			'header_static' => '',
			'emojis' => [],
			'moved' => null,
			'fields' => null,
			'bot' => null,
			'software' => 'pixelfed',
			'is_admin' => (bool) $is_admin,
		];
	}
}
