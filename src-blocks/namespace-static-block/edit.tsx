import { useBlockProps } from "@wordpress/block-editor";
import { BlockEditProps } from "@wordpress/blocks";

export type Attributes = {};

export default function Edit({
    attributes,
    setAttributes,
}: BlockEditProps<Attributes>) {
    const blockProps = useBlockProps({});

    return (
        <div {...blockProps}>
            <h1>Blueprint for a Static Block</h1>
        </div>
    );
}