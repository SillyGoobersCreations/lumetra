<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $handle
 * @property string $first_name
 * @property string $last_name
 * @property string|null $avatar_url
 * @property int $confirmed
 * @property string|null $confirmation_key
 * @property string|null $description
 * @property string|null $job_company
 * @property string|null $job_position
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $event_id
 * @property string $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttendeeContactInfo> $contact_infos
 * @property-read int|null $contact_infos_count
 * @property-read \App\Models\Event|null $event
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereConfirmationKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereHandle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereJobCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereJobPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereUserId($value)
 */
	class Attendee extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $state
 * @property string|null $notes
 * @property string|null $intro_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $inviter_attendee_id
 * @property string $invitee_attendee_id
 * @property-read \App\Models\Attendee|null $invitee_attendee
 * @property-read \App\Models\Attendee|null $inviter_attendee
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection whereIntroText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection whereInviteeAttendeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection whereInviterAttendeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection whereUpdatedAt($value)
 */
	class AttendeeConnection extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $type
 * @property string $value
 * @property string $visibility
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $attendee_id
 * @property-read \App\Models\Attendee|null $attendee
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo whereAttendeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo whereVisibility($value)
 */
	class AttendeeContactInfo extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $message
 * @property int $is_room_slot_invite
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $sender_attendee_id
 * @property string $receiver_attendee_id
 * @property-read \App\Models\Attendee|null $receiver_attendee
 * @property-read \App\Models\Attendee|null $sender_attendee
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereIsRoomSlotInvite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereReceiverAttendeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereSenderAttendeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereUpdatedAt($value)
 */
	class ChatMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $title
 * @property string $organizer
 * @property string|null $logo
 * @property string|null $description
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $color_primary
 * @property string|null $color_secondary
 * @property int $confirmation_required
 * @property int $confirmation_personalized
 * @property int|null $room_slot_max_pending
 * @property int|null $room_slot_max_claimed
 * @property int $room_slot_team_confirmation_required
 * @property int|null $attendees_max
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendee> $attendees
 * @property-read int|null $attendees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventNote> $notes
 * @property-read int|null $notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventRoom> $rooms
 * @property-read int|null $rooms_count
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereAttendeesMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereColorPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereColorSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereConfirmationPersonalized($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereConfirmationRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereOrganizer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereRoomSlotMaxClaimed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereRoomSlotMaxPending($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereRoomSlotTeamConfirmationRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 */
	class Event extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $title
 * @property string $text
 * @property int $sticky
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $event_id
 * @property-read \App\Models\Event|null $event
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote whereSticky($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote whereUpdatedAt($value)
 */
	class EventNote extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string|null $location
 * @property string|null $notes
 * @property int $available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $event_id
 * @property-read \App\Models\Event|null $event
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventRoomSlot> $slots
 * @property-read int|null $slots_count
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom whereUpdatedAt($value)
 */
	class EventRoom extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $start_date
 * @property string $end_date
 * @property string|null $notes
 * @property string $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $event_room_id
 * @property-read \App\Models\EventRoomSlotClaim|null $claims
 * @property-read \App\Models\EventRoom|null $room
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot whereEventRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot whereUpdatedAt($value)
 */
	class EventRoomSlot extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $event_room_slot_id
 * @property string $inviter_attendee_id
 * @property string $invitee_attendee_id
 * @property-read \App\Models\Attendee|null $invitee_attendee
 * @property-read \App\Models\Attendee|null $inviter_attendee
 * @property-read \App\Models\EventRoomSlot|null $slot
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim whereEventRoomSlotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim whereInviteeAttendeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim whereInviterAttendeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim whereUpdatedAt($value)
 */
	class EventRoomSlotClaim extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $is_admin
 * @property int $is_event_creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendee> $attendees
 * @property-read int|null $attendees_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsEventCreator($value)
 */
	class User extends \Eloquent {}
}

