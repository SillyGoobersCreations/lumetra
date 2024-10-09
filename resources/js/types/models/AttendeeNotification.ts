import {Attendee} from "@/types/models/Attendee";

export interface AttendeeNotification {
    id: string;
    type: 'system' | 'note_new' | 'connection_new' | 'connection_answer' | 'claim_new' | 'claim_answer' | 'chat_new';
    text: string;
    link: string;
}
