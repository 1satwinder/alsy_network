<?php

namespace App\Jobs;

use App\Models\MagicPool;
use App\Models\MagicPoolTree;
use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class AddMemberOnPool implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Member $member;

    private MagicPool $magicPool;

    /**
     * Create a new job instance.
     */
    public function __construct(Member $member, MagicPool $magicPool)
    {
        $this->member = $member;
        $this->magicPool = $magicPool;
    }

    /**
     * Execute the job.
     *
     * @throws Throwable
     */
    public function handle(): void
    {
        $magicPoolMember = \DB::transaction(function () {
            if (MagicPoolTree::where('member_id', $this->member->id)
                ->where('magic_pool_id', $this->magicPool->id)
                ->lockForUpdate()
                ->doesntExist()
            ) {
                $parent = MagicPoolTree::whereHas('children', null, '<', 4)
                    ->where('magic_pool_id', $this->magicPool->id)
                    ->orderBy('level', 'asc')
                    ->orderBy('position', 'asc')
                    ->lockForUpdate()
                    ->first();

                if ($parent) {
                    $magicPoolMember = MagicPoolTree::create([
                        'member_id' => $this->member->id,
                        'parent_id' => $parent->id,
                        'magic_pool_id' => $this->magicPool->id,
                        'level' => $parent->level + 1,
                        'position' => 1,
                    ]);
                    $parent->refresh();
                    $magicPoolMember->position = ($parent->position * 4) - (1 - $parent->children->count() + 1);
                    $magicPoolMember->path = $parent->path.'/'.$magicPoolMember->id;
                } else {
                    $magicPoolMember = MagicPoolTree::create([
                        'member_id' => $this->member->id,
                        'magic_pool_id' => $this->magicPool->id,
                        'level' => 1,
                        'position' => 1,
                    ]);
                    $magicPoolMember->path = $magicPoolMember->id;
                }
                $magicPoolMember->save();

                return $magicPoolMember;
            }
        });

        if ($magicPoolMember && $magicPoolMember->parent && $magicPoolMember->parent->children->count() >= 4) {
            CalculateMagicPoolIncome::dispatch($magicPoolMember->parent);
        }
    }
}
