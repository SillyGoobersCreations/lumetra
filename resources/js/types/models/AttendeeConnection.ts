import { Attendee } from '@/types/models/Attendee';

export interface AttendeeConnection {
    id: string;
    state: string;
    notes: string | null;
    intro_text: string | null;
    created_at: Date | null;
    updated_at: Date | null;
    inviter_attendee_id: string;
    invitee_attendee_id: string;
    invitee_attendee: Attendee | null;
    inviter_attendee: Attendee | null;
}
