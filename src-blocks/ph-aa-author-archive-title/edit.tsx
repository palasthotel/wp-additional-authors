import { useBlockProps } from "@wordpress/block-editor";
import { BlockEditProps } from "@wordpress/blocks";

type Attributes = {};

export default function Edit({
    attributes,
    setAttributes,
}: BlockEditProps<Attributes>) {
    const blockProps = useBlockProps({});

    return (
        <div {...blockProps}>
            <h1>Additional Author Archive Title</h1>
        </div>
    );
}
