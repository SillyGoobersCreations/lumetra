import {Event} from "@/types/models/Event";

export interface EventNote {
    id: string;
    title: string;
    text: string;
    sticky: boolean;
    created_at: Date | null;
    updated_at: Date | null;
    event_id: string;
    event: Event | null;
}
